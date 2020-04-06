<?php



class sw_StockLocation_Block_Blocks extends Mage_Core_Block_Template {

	public function getBlocksCollection() {
		$newsCollection = Mage::getModel('swstocklocation/blocks')->getCollection();
		$newsCollection->setOrder('id', 'DESC');
		return $newsCollection;
	}


}



