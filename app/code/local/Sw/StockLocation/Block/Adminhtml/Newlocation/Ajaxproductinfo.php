<?php


class Sw_StockLocation_Block_Adminhtml_Newlocation_Ajaxproductinfo extends  Mage_Adminhtml_Block_Abstract //
	// Mage_Core_Block_Template //
	// Mage_Adminhtml_Block_Dashboard_Bar
{
    protected function _construct() {
        parent::_construct();
		$this->setTemplate('swstocklocation/newlocation_ajaxproductinfo.phtml');
    }

	public function getLocationsOfProduct ($idProd) {
		$arLocations = array();

    	$arLocations = array(
    		array(
				'name'=>'M8-3-50/7C',
				'qty'=> 45,
				'id'=>'5',
			)
		);
//    	$collectionOfSizes =  Mage::getModel('swstocklocation/sizelocation')->getCollection()->load();
//		foreach($collectionOfSizes AS $Obj) {
//			$arSizes[$Obj->getId()] = array (
//				'name' => $Obj->getName(),
//				'volume' => $Obj->getVolume(),
//				'description' => $Obj->getDescription(),
//			);
//		}
		return $arLocations;
	}

}

