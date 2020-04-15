<?php

class Sw_StockLocation_Model_Resource_Locations_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract {

	public function _construct() {
		parent::_construct();
		$this->_init('swstocklocation/locations');
	}

}

