<?php

class sw_StockLocation_Model_Resource_Zones_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract {

	public function _construct() {

		parent::_construct();
		$this->_init('swstocklocation/zones');

	}

}

