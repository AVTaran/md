<?php


class Sw_StockLocation_Block_Adminhtml_Integration_Ajax extends  Mage_Adminhtml_Block_Abstract
{
    protected function _construct()
    {
        parent::_construct();
		$this->setTemplate('swstocklocation/ajax.phtml');
    }

	public function getAjaxContent() {
		$params = $this->getRequest()->getParams();

		switch ($params['operation']) {
			case 'ShiftExistingLocations':
				$content = $this->ajaxShiftExistingLocations($params['param']);
				break;
			case 'countSizeOfLocations':
				$content = $this->ajaxCountSizeOfLocations($params['param']);
				break;
			default:
				$content = $this->getAjaxDefault();
			break;
		}

		$content = json_encode($content, 0, 512);
		return $content;
	}

	public function ajaxShiftExistingLocations($params) {
		$ret = $arLocations = $arUnmatchedRecords = array();

		$pathOfDirI = Mage::getBaseDir().DS.'integration'.DS;
		$pathOfFileLocation = $pathOfDirI.'ShelfLocationExport-04May2020.xlsx';
		if( !file_exists($pathOfFileLocation)) {
			return $ret;
		}

		require_once ($pathOfDirI.'lib'.DS.'vendor'.DS.'autoload.php');
		$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
		$spreadsheet = $reader->load($pathOfFileLocation);
		$sheetData = $spreadsheet
			->getActiveSheet()
			->toArray(null, true, true, true)
		;

		array_shift($sheetData);
		$ret['totalRows'] = count($sheetData);

		// Separate the source data by parts and take a portion to manipulate with
		$sheetData = array_slice( $sheetData, ($params['number']*($params['portion']-1)), $params['number']);

		foreach ($sheetData AS $r => $rowData) {
			foreach ($rowData AS $c => $cellData) {
				$cellData = trim($cellData);
				if ($cellData=='') {
					continue;
				}
				$arUnmatchedRecords[] = $cellData;

				// M1-1-98/108
				if (preg_match('/(M)([1|4|5]-[1|2|3])-(\d+)\/?(\d+)?/m', $cellData, $out)) {
					$arLocations[] = array($out[0],$out[1],$out[2],$out[3]);
					if ( isset($out[4]) AND $out[4]!='' ) {
						$arLocations[] = array($out[0],$out[1],$out[2],$out[4]);
					}
					array_pop($arUnmatchedRecords);
					continue;
				}

				$arPatterns = array (
					// M8-1-50/3A, O4-2B-40/4A,
					'/([M|O|U|P|N])(\d+-\d+[A|B]?)-?(\d+)\/(\d+)(\w*)/mi',

					// S-IR1-E-A1, S-WR3-B-F12, S-IR6-E-20/A, S-IR5-A-30
					'/^(S)-(\w+?\d+)-(\w+)-(\D+)?(\d+)\/?(\D)?$/mi',

					// O1-1-N1, O1-1-GAP
					// S-ROD, S-CR2
					// S-AR9-T, S-AR9-B
					// S-CG1-B-A5, S-CG1-D-10
					// Freezer-1
					// C2-40-L/F, C2-40-M/F, C2-50-R
				);

				foreach ($arPatterns AS $p => $pattern) {
					if (preg_match ($pattern, $cellData, $out)) {
						foreach ($out AS $i => $v){
							if (is_null($v) or $v==''){
								unset ($out[$i]);
							}
						}
						$out = array_pad($out,6,null);
						$arLocations[] = $out;
						array_pop($arUnmatchedRecords);
						break;
					}
				}

				if ($c==0) {
					array_pop($arUnmatchedRecords);
				}
			}
		}

		// new locations are added to database
		if (count($arLocations)>0){
			foreach ($arLocations AS $k => $location) {
				$location = array_pad($location,6,null);
				$this->addLocationInDB($location[1], $location[2], $location[3], $location[4], $location[5] );
			}
		}

		// $this->countSizeOfLocations();

		//$ret['arLocations'] = $arLocations;
		$ret['arUnmatchedRecords'] = $arUnmatchedRecords;
		if (count($sheetData)<$params['number']) {
			$ret['completeRows'] = $ret['totalRows'];
		} else {
			$ret['completeRows'] = count($sheetData)*$params['portion'];
		}

		return $ret;
	}

	public function addLocationInDB($zone, $block=null, $shelf=null, $box=null, $section=null ) {
    	$ret = false;
    	$locationData = array (
			'id_zone' => null,
			'id_block' => null,
			'id_shelf' => null,
			'id_box' => null,
			'id_section' => null
		);

		// ----------------
		// add zone
		$resAdd = $this->addSlObject('zones', array('name'=>$zone));
		if (isset($resAdd['id'])) {
			$locationData['id_zone'] = $resAdd['id'];
		}

		// ----------------
		// add block
		if (!is_null($block) AND !is_null($locationData['id_zone'])) {
			$additionData = array();
			if (in_array($zone, array('M', 'O', 'U', 'N', 'P'))) {
				$additionData = array(
					'length'	=>'270',
					'width'		=>'45',
					'height'	=>'2000',
				);
			}
			// print_r($additionData);
			$resAdd = $this->addSlObject('blocks',
				array(
					'id_zone'	=> $locationData['id_zone'],
					'name'		=> $block,
				),
				$additionData
			);
			if (isset($resAdd['id'])) {
				$locationData['id_block'] = $resAdd['id'];
			}
		}

		// ----------------
		// add shelf
		if (!is_null($shelf) AND !is_null($locationData['id_block'])) {
			$resAdd = $this->addSlObject('shelfs',
				array(
					'id_block'	=> $locationData['id_block'],
					'name'		=> $shelf,
				)
			);
			if (isset($resAdd['id'])) {
				$locationData['id_shelf'] = $resAdd['id'];
			}
		}

		// ----------------
		// add box
		if (!is_null($box) AND !is_null($locationData['id_shelf'])) {
			$id_typebox = 1;
			if ($zone=='M' AND in_array($block, array('1-1','1-2','1-3','4-1','4-2','4-3','5-1','5-2','5-3'))) {
				$id_typebox = 2;
			}
			$resAdd = $this->addSlObject('boxes',
				array(
					'id_shelf'	=> $locationData['id_shelf'],
					'name'		=> $box,
				),
				array(
					'id_typebox'=> $id_typebox
				)
			);
			if (isset($resAdd['id'])) {
				$locationData['id_box'] = $resAdd['id'];
			}
		}

		// ----------------
		// add section
		if (!is_null($section) AND !is_null($locationData['id_box'])) {
			$resAdd = $this->addSlObject('sections',
				array(
					'id_box'	=> $locationData['id_box'],
					'name'		=> $section,
				)
			);
			if (isset($resAdd['id'])) {
				$locationData['id_section'] = $resAdd['id'];
			}
		}

		// ----------------
		// Add Location
		if (!is_null($locationData['id_zone']) AND !is_null($locationData['id_block'])) {
			$ret = $this->addSlObject('locations', $locationData);
		}
    	return $ret;
	}

	public function addSlObject($model, $data, $additionData=array()) {
		$objList = Mage::getModel('swstocklocation/'.$model)->getCollection();
		foreach ($data AS $field => $val) {
			if (is_null($val)){
				$objList->addFieldToFilter($field, array('null' => true));
			} else {
				$objList->addFieldToFilter($field, array('eq' => $val));
			}
		}

		$objList->load();
		$arObjList = $objList->toArray();

		if ($arObjList['totalRecords']>0) {
			$idObj = $arObjList['items'][0]['id'];
		} elseif ($arObjList['totalRecords']==0) {
			try {
				$data = array_merge($data, $additionData);
				$model = Mage::getModel('swstocklocation/'.$model)
					->setData($data)
					->save()
				;
				$idObj = $model->getId();
			} catch (Exception $e) {
				$ret['error'][] = $e->getMessage();
			}
		} else {
			$ret['warning'][] = 'Something wrong. Several records of '.$model.' with the same param(s)';
		}
		if ($idObj==null) {
			$ret['error'][] = 'Something wrong. Can\'t catch the ID of '.$model.'.';
		} else {
			$ret['id'] = $idObj;
		}
		return $ret;
	}

	public function ajaxCountSizeOfLocations($params) {
		// Mage::helper('swstocklocation')->reCountSizeLocations('zones', 1);
		// Mage::helper('swstocklocation')->reCountSizeLocations('blocks', 5);
		// Mage::helper('swstocklocation')->reCountSizeLocations('shelfs', 2);
		// Mage::helper('swstocklocation')->reCountSizeLocations('boxes', 3);
		// Mage::helper('swstocklocation')->reCountSizeLocations('boxes', 2301);

    	if (!isset($params['obj'])) {
			$params['obj'] = 'zones';
		}
		if (!isset($params['objId'])) {
			$objId = $params['objId'];
		} else {
			$objId = null;
		}

		$arObjChildList = Mage::getModel('swstocklocation/zones')->getCollection()->load($objId)->toArray();
		if ($arObjChildList['totalRecords']>0) {
			foreach ($arObjChildList['items'] AS $k => $item) {
				Mage::helper('swstocklocation')->reCountSizeLocations($params['obj'], $item['id']);
			}
		}

	}

	public function getAjaxDefault () {
    	return 'unknown request';
	}

}
