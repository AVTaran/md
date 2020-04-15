<?php

class Sw_StockLocation_Model_Sections extends Mage_Core_Model_Abstract {

	public function _construct() {
		parent::_construct();
		$this->_init('swstocklocation/sections');
	}

}