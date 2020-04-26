<?php


class Sw_StockLocation_Block_Adminhtml_Newlocation_Filter extends  Mage_Adminhtml_Block_Abstract //
	// Mage_Core_Block_Template //
	// Mage_Adminhtml_Block_Dashboard_Bar
{
    protected function _construct() {
        parent::_construct();
		$this->setTemplate('swstocklocation/newlocation_filter.phtml');
    }

	public function getBoxesSizes () {
    	$arSizes = array();
    	$collectionOfSizes =  Mage::getModel('swstocklocation/sizelocation')->getCollection()->load();
		foreach($collectionOfSizes AS $Obj) {
			$arSizes[$Obj->getId()] = array (
				'name' => $Obj->getName(),
				'volume' => $Obj->getVolume(),
				'description' => $Obj->getDescription(),
			);
		}
		return $arSizes;
	}


	public function getZones () {
		$arZones = array();
		$collectionOfZones =  Mage::getModel('swstocklocation/zones')->getCollection()->load();
		foreach($collectionOfZones AS $Obj) {
			$arZones[$Obj->getId()] = array (
				'name' => $Obj->getName(),
				'volume' => $Obj->getVolume(),
				'description' => $Obj->getDescription(),
			);
		}
		return $arZones;
	}

	public function getTypeBoxes () {
		$arTypeBoxes = array();
		$collectionOfTypeBoxes =  Mage::getModel('swstocklocation/typeboxes')->getCollection()->load();
		foreach($collectionOfTypeBoxes AS $Obj) {
			$arTypeBoxes[$Obj->getId()] = array (
				'name' => $Obj->getName(),
				'volume' => $Obj->getVolume(),
				'description' => $Obj->getDescription(),
			);
		}
		return $arTypeBoxes;
	}


}
