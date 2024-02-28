<?php

class Sw_StockLocation_Model_Resource_Locations extends Mage_Core_Model_Mysql4_Abstract {

	public function _construct() {
		$this->_init('swstocklocation/table_location', 'id');
	}

}

