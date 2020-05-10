<?php

class Sw_StockLocation_Helper_Data extends Mage_Core_Helper_Abstract {

	public function getObjectList($obj, $fieldId = 'Id', $fieldName = 'Name') {
		$ObjList = Mage::getModel('swstocklocation/'.$obj)->getCollection()->load();
		$output = array();
		foreach($ObjList as $Obj) {
			$id				= $Obj->{'get'.$fieldId}();
			$output[$id]	= $Obj->{'get'.$fieldName}();
		}
		return $output;
	}

	public function getObjectOptions($obj, $fields = array('value'=>'Id', 'label'=>'Name')) {
		$ObjList = Mage::getModel('swstocklocation/'.$obj)->getCollection()->load();
		$options = $anOption = array();

		// a default option
		foreach ($fields AS $par => $var) {
			$anOption[$par] = '';
		}
		$options[] = $anOption;

		// pairs: parametr-value 
		foreach ($ObjList as $Obj) {
			$anOption = array();
			foreach ($fields AS $par => $var) {
				$anOption[$par] = $Obj->{'get'.$var}();
			}
			$options[] = $anOption;
		}
		return $options;
	}


	public function getLocationName ($idLocation) {
		$locationName = '';

		$ObjLocation = Mage::getModel('swstocklocation/locations')->load($idLocation);
		$rawLocationData = $ObjLocation->toArray();

		if (!is_null($rawLocationData['id_zone']) AND $rawLocationData['id_zone']>0) {
			$zoneName = Mage::getModel('swstocklocation/zones')
				->load($rawLocationData['id_zone'])
				->getName()
			;
			$locationName .= $zoneName;
		}
		if($zoneName=='S'){
			$locationName .= '-';
		}

		if (!is_null($rawLocationData['id_block']) AND $rawLocationData['id_block']>0) {
			$blockName = Mage::getModel('swstocklocation/blocks')
				->load($rawLocationData['id_block'])
				->getName()
			;
			$locationName .= $blockName;
		}
		if (!is_null($rawLocationData['id_shelf']) AND $rawLocationData['id_shelf']>0) {
			$shelfName = Mage::getModel('swstocklocation/shelfs')
				->load($rawLocationData['id_shelf'])
				->getName()
			;
			$locationName .= '-'.$shelfName;
		}
		if (!is_null($rawLocationData['id_box']) AND $rawLocationData['id_box']>0) {
			$boxName = Mage::getModel('swstocklocation/boxes')
				->load($rawLocationData['id_box'])
				->getName()
			;
			$locationName .= '/'.$boxName;
		}
		if (!is_null($rawLocationData['id_section']) AND $rawLocationData['id_section']>0) {
			$sectionName = Mage::getModel('swstocklocation/sections')
				->load($rawLocationData['id_section'])
				->getName()
			;
			$locationName .= $sectionName;
		}

		$locationName .= ' ('.implode('x', $this->getLocationSize($idLocation)).')';

		return $locationName;
	}

	public function getLocationSize ($idLocation, $approx=true) {
		$ObjLocation = Mage::getModel('swstocklocation/locations')->load($idLocation);
		$rawLocationData = $ObjLocation->toArray();

		if (!is_null($rawLocationData['id_zone']) AND $rawLocationData['id_zone']>0) {
			$obj = Mage::getModel('swstocklocation/zones')->load($rawLocationData['id_zone'])->toArray();
		}
		if (!is_null($rawLocationData['id_block']) AND $rawLocationData['id_block']>0) {
			$obj = Mage::getModel('swstocklocation/blocks')->load($rawLocationData['id_block'])->toArray();
		}
		if (!is_null($rawLocationData['id_shelf']) AND $rawLocationData['id_shelf']>0) {
			$obj = Mage::getModel('swstocklocation/shelfs')->load($rawLocationData['id_shelf'])->toArray();
		}
		if (!is_null($rawLocationData['id_box']) AND $rawLocationData['id_box']>0) {
			$obj = Mage::getModel('swstocklocation/boxes')->load($rawLocationData['id_box'])->toArray();
		}
		if (!is_null($rawLocationData['id_section']) AND $rawLocationData['id_section']>0) {
			$obj = Mage::getModel('swstocklocation/sections')->load($rawLocationData['id_section'])->toArray();
		}

		$locationSize = $this->getDimensions($obj, true);
		return $locationSize;
	}

	public function getDimensions($rowData, $includApprox = false) {
		$dimensions = array('h' => null, 'w' => null, 'l' => null);
		if (!is_null($rowData['approx_height']) AND $rowData['approx_height']>0 AND $includApprox) {
			$dimensions['h'] = $rowData['approx_height'];
		}
		if (!is_null($rowData['height']) AND $rowData['height']>0) {
			$dimensions['h'] = $rowData['height'];
		}
		if (!is_null($rowData['approx_width']) AND $rowData['approx_width']>0 AND $includApprox) {
			$dimensions['w'] = $rowData['approx_width'];
		}
		if (!is_null($rowData['width']) AND $rowData['width']>0) {
			$dimensions['w'] = $rowData['width'];
		}
		if (!is_null($rowData['approx_length']) AND $rowData['approx_length']>0 AND $includApprox) {
			$dimensions['l'] = $rowData['approx_length'];
		}
		if (!is_null($rowData['length']) AND $rowData['length']>0) {
			$dimensions['l'] = $rowData['length'];
		}
		return $dimensions;
	}

	public function reCountSizeLocations ($obj, $objId) {
		$ret = null;

		$rulesToReduceValueOfChildTotal = array(
			'blocks' => array(
				'h'=>'$dimensionsChildTotal["h"] = round($dimensionsParent["h"]*0.8, 0);',
				'w'=>'$dimensionsChildTotal["w"] = round(
					sqrt($dimensionsChildTotal["w"]*$dimensionsChildTotal["l"] - $dimensionsChild["w"]*$dimensionsChild["l"]),
					0
				);',
				'l'=>'$dimensionsChildTotal["l"] = $dimensionsChildTotal["w"];',
			),
			'shelfs' => array(
				'h'=>'$dimensionsChildTotal["h"] = $dimensionsChildTotal["h"] - $dimensionsChild["h"];',
				'w'=>'$dimensionsChildTotal["w"] = $dimensionsParent["w"];',
				'l'=>'$dimensionsChildTotal["l"] = $dimensionsParent["l"];',
			),
			'boxes' => array(
				'h'=>'$dimensionsChildTotal["h"] = round($dimensionsParent["h"]*0.85, 0);',
				'w'=>'$dimensionsChildTotal["w"] = round($dimensionsParent["w"]*0.95, 0);',
				'l'=>'$dimensionsChildTotal["l"] = $dimensionsChildTotal["l"] - $dimensionsChild["l"];',
			),
			'sections' => array(
				'h'=>'$dimensionsChildTotal["h"] = round($dimensionsParent["h"]*0.9, 0);',
				'w'=>'$dimensionsChildTotal["w"] = round(
					sqrt($dimensionsChildTotal["w"]$dimensionsChildTotal["l"] - $dimensionsChild["w"]$dimensionsChild["l"]),
					0
				);',
				'l'=>'$dimensionsChildTotal["l"] = $dimensionsChildTotal["w"];',
			),
		);
		$rulesToCountApproxDimension = array(
			'blocks' => array(
				'h'=>'$dimensionsChildAverage["approx_height"] = round($dimensionsChildTotal["h"]/$totalChildWithoutDimensions*0.8, 0);',
				'w'=>'$dimensionsChildAverage["approx_width"]  = round($dimensionsChildTotal["w"]/$totalChildWithoutDimensions*0.5, 0);',
				'l'=>'$dimensionsChildAverage["approx_length"] = round($dimensionsChildTotal["l"]/$totalChildWithoutDimensions*0.5, 0);',
			),
			'shelfs' => array(
				'h'=>'$dimensionsChildAverage["approx_height"] = round($dimensionsChildTotal["h"]/$totalChildWithoutDimensions*0.85, 0);',
				'w'=>'$dimensionsChildAverage["approx_width"]  = $dimensionsParent["w"];',
				'l'=>'$dimensionsChildAverage["approx_length"] = $dimensionsParent["l"];',
			),
			'boxes' => array(
				'h'=>'$dimensionsChildAverage["approx_height"] = round($dimensionsParent["h"]*0.85, 0);',
				'w'=>'$dimensionsChildAverage["approx_width"]  = round($dimensionsParent["w"]*0.95, 0);',
				'l'=>'$dimensionsChildAverage["approx_length"] = round($dimensionsChildTotal["l"]/$totalChildWithoutDimensions*0.95, 0);',
			),
			'sections' => array(
				'h'=>'$dimensionsChildAverage["approx_height"] = round($dimensionsParent["h"]*0.9, 0);',
				'w'=>'$dimensionsChildAverage["approx_width"]  = 
						round(
							sqrt(
								($dimensionsParent["w"] * $dimensionsParent["l"])/$totalChildWithoutDimensions
							),
						 0
						);
					',
				'l'=>'$dimensionsChildAverage["approx_length"] = $dimensionsChildAverage["approx_width"];',
			),
		);

		switch ($obj) {
			case 'zones': default :
				$obj = 'zones';
				$objIdField = 'id_zone';
				$objChild = 'blocks';
				$tableChild = 'table_block';
				break;
			case 'blocks':
				$obj = 'blocks';
				$objIdField = 'id_block';
				$objChild = 'shelfs';
				$tableChild = 'table_shelf';
				break;
			case 'shelfs':
				$obj = 'shelfs';
				$objIdField = 'id_shelf';
				$objChild = 'boxes';
				$tableChild = 'table_box';
				break;
			case 'boxes':
				$obj = 'boxes';
				$objIdField = 'id_box';
				$objChild = 'sections';
				$tableChild = 'table_section';
				break;
			case 'sections':
				$obj = 'sections';
				$objIdField = 'id_section';
				$objChild = null;
				$tableChild = null;
				break;
		}
//		echo $obj."\n";
//		echo $objChild."\n\n";

		// ----------------
		$Parent = Mage::getModel('swstocklocation/'.$obj)->load($objId)->toArray();
		$dimensionsParent = $this->getDimensions($Parent, true);
		if (is_null($dimensionsParent['l']) OR is_null($dimensionsParent['h']) OR is_null($dimensionsParent['w'])) {
			return $ret;
		}

		// =================
		if (is_null($objChild)) {
			return $ret;
		}
		$objChildList = Mage::getModel('swstocklocation/'.$objChild)->getCollection();
		$objChildList->addFieldToFilter($objIdField, array('eq' => $objId));
		$objChildList->load();
		$arObjChildList = $objChildList->toArray();

//		echo '<pre>$dimensionsParent '."\n";
//		print_r($dimensionsParent);
//		echo '</pre>';
//		echo '<pre>totalRecords: '."\n";
//		print_r($arObjChildList['totalRecords']);
//		echo '</pre>';

		if ($arObjChildList['totalRecords']==0) {
			return $ret;
		}

		$childWithoutExistentSize = array();
		$dimensionsChildTotal = $dimensionsParent;
		foreach ($arObjChildList['items'] AS $k => $child) {
			$dimensionsChild = $this->getDimensions($child);
//			echo '<pre>$dimensionsChild '."\n";
//			print_r($dimensionsChild);
//			echo '</pre>';

			if (
					!is_null($dimensionsChild['h'])
				  AND
					!is_null($dimensionsChild['l'])
				  AND
					!is_null($dimensionsChild['w'])
			) {
				eval($rulesToReduceValueOfChildTotal[$objChild]['h']);
				eval($rulesToReduceValueOfChildTotal[$objChild]['w']);
				eval($rulesToReduceValueOfChildTotal[$objChild]['l']);

//				echo '<pre>$dimensionsChildTotal';
//				print_r($dimensionsChildTotal);
//				echo '</pre>';
			} else {
				$childWithoutExistentSize[] = $child['id'];
			}
		}

//		echo '<pre>$dimensionsChildTotal'."\n";
//		print_r($dimensionsChildTotal);
//		echo '</pre>';

		$totalChildWithoutDimensions = count($childWithoutExistentSize);
		$dimensionsChildAverage = array(
			'approx_height' => null,
			'approx_width'  => null,
			'approx_length' => null,
		);
		if ($totalChildWithoutDimensions>0) {
			eval($rulesToCountApproxDimension[$objChild]['h']);
			eval($rulesToCountApproxDimension[$objChild]['w']);
			eval($rulesToCountApproxDimension[$objChild]['l']);
		}

//		echo '<pre>$childWithoutExistentSize'."\n";
//		print_r($childWithoutExistentSize);
//		echo '</pre>';
//
//		echo '<pre>$dimensionsChildAverage'."\n";
//		print_r($dimensionsChildAverage);
//		echo '</pre>';


		foreach ($arObjChildList['items'] AS $k => $child) {
			if ( in_array($child['id'], $childWithoutExistentSize) ) {

				$resource = Mage::getSingleton('core/resource');
				$table = $resource->getTableName('swstocklocation/'.$tableChild);

				$writeConnection = Mage::getSingleton('core/resource')->getConnection('core_write');
				$writeConnection->update($table, $dimensionsChildAverage, "id=".$child['id'] );
			}
			// echo '->reCountSizeLocations('.$objChild.', '.$child['id'].');'."\n";
			$ret = Mage::helper('swstocklocation')->reCountSizeLocations($objChild, $child['id']);
		}

		return $ret;
	}


}
