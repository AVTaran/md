<?php


class Sw_StockLocation_Block_Adminhtml_Ajax extends  Mage_Adminhtml_Block_Abstract
{
    protected function _construct()
    {
        parent::_construct();
		$this->setTemplate('swstocklocation/ajax.phtml');
    }

	public function getAjaxContent() {
		$params = $this->getRequest()->getParams();

		switch ($params['operation']) {
			case 'getOptionsForSelect':
				$content = $this->getAjaxOptionsForSelect($params['param']);
				break;

			case 'getOptionsForSelects':
				$content = $this->getAjaxOptionsForSelects($params['param']);
				break;

			default:
				$content = $this->getAjaxDefault();
			break;
		}

		$content = json_encode($content, 0, 512);
		return $content;
	}

	public function getAjaxOptionsForSelects ($params) {
		$ret = array();

		$arTargets = json_decode(base64_decode($params['arTargets']));

//		$arObj = '[{obj:\'id_zone\', target:\'id_block\'}, {obj:\'id_block\', target:\'id_shelf\'}]';
//		$ret[] = $this->getAjaxOptionsForSelect(array('curObjId'=>'id_zone', 'targetSelect'=>'id_block'));
//		$ret[] = $this->getAjaxOptionsForSelect(array('curObjId'=>'id_block', 'targetSelect'=>'id_shelf'));

		foreach ($arTargets AS $k => $tar) {
			$curObjId = array(
				'curObj' 		=> $tar->obj,
				'targetSelect'	=> $tar->target
			);
			if ($k==0) {
				$curObjId['curObjId'] = $params['curObjId'];
			}

			$ret[] = $this->getAjaxOptionsForSelect($curObjId);
		}

		return $ret;
	}


	public function getAjaxOptionsForSelect ($params) {
		$ret = $OptionsForSelect = array();
		if (!isset($params['curObjId'])) {
			$params['curObjId'] = 0;
		}
		$params['curObjId'] = $params['curObjId']+0;

		$targetSelect = explode('_', $params['targetSelect']);
		$targetSelect = $targetSelect[1].'s';
		$targetSelect = str_replace('box', 'boxe', $targetSelect);


		$resource = Mage::getSingleton('core/resource');
		$tableL  = $resource->getTableName('swstocklocation/table_location');
		$tableZ  = $resource->getTableName('swstocklocation/table_zone');
		$tableBl = $resource->getTableName('swstocklocation/table_block');
		$tableSh = $resource->getTableName('swstocklocation/table_shelf');
		$tableBo = $resource->getTableName('swstocklocation/table_box');
		$tableSe = $resource->getTableName('swstocklocation/table_section');

		$connection = $resource->getConnection('core_read');

		// echo $targetSelect.'<br>';
		switch ($targetSelect) {
			case 'zones':
				$select = $connection
					->select()
					->from(['z' => $tableZ], ['z.id', 'z.name' ])
					->where('z.'.$params['curObj'].'='.$params['curObjId'])
				;
				break;
			case 'blocks':
				$select = $connection
					->select()
					->from(['bl' => $tableBl], ['bl.id', 'bl.name' ])
					->where('bl.'.$params['curObj'].'='.$params['curObjId'])
				;
				break;
			case 'shelfs':
				$select = $connection
					->select()
					->from(['sh' => $tableSh], ['sh.id', 'sh.name' ])
					->where('sh.'.$params['curObj'].'='.$params['curObjId'])
				;
				break;
			// default
		}


		// echo $select;
		if ($select!=''){
			$OptionsForSelect = $connection->fetchAll($select);
		}

		$ret['OptionsForSelect'] 	= $OptionsForSelect;
		$ret['targetSelect'] 		= $params['targetSelect'];

		return $ret;
	}


	public function getAjaxDefault () {
    	return 'unknown request';
	}

}


