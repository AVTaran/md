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
			default:
				$content = $this->getAjaxDefault();
			break;
		}

		$content = json_encode($content, 0, 512);
		return $content;
	}

	public function getAjaxOptionsForSelect ($params) {
		$ret = $OptionsForSelect = array();
		$params['curObjId'] = $params['curObjId']+0;

		$targetSelect = explode('_', $params['targetSelect']);
		$targetSelect = $targetSelect[1].'s';
		$targetSelect = str_replace('box', 'boxe', $targetSelect);
		// return $targetSelect;

		//		$objModel = Mage::getModel('swstocklocation/'.$targetSelect)
		//			->getCollection()
		//			->addAttributeToSelect('*')
		//			->addAttributeToFilter( $params['curObj'], array('eq' => $params['curObjId']) )
		//		;
		//		echo $objModel->getSelect();
		//
		//		foreach ($objModel AS $k => $obj) {
		//			$OptionsForSelect[$obj->getID()] = $obj->getName();
		//		}


		$resource = Mage::getSingleton('core/resource');
		$connection = $resource->getConnection('core_read');

		// $tableBl = $resource->getTableName('swstocklocation/blocks');
		$tableBl = 'sw_sl_block';

		// $params['curObjId'] = 1;

		$select = $connection
			->select()
			->from(['t' => $tableBl], ['t.id', 't.name' ])
			->where('t.'.$params['curObj'].'='.$params['curObjId'])
		;
		// echo $select;
		$OptionsForSelect = $connection->fetchAll($select);

		$ret['OptionsForSelect'] 	= $OptionsForSelect;
		$ret['targetSelect'] 		= $params['targetSelect'];
		return $ret;
	}


	public function getAjaxDefault () {
    	return 'unknown request';
	}

}


