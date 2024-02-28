<?php


class Sw_StockLocation_Block_Zones extends Mage_Core_Block_Template {

	public function getZonesCollection() {
		$newsCollection = Mage::getModel('swstocklocation/zones')->getCollection();
		$newsCollection->setOrder('id', 'DESC');
		return $newsCollection;
	}

}



