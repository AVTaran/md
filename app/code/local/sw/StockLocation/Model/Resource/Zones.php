<?php

class sw_StockLocation_Model_Resource_Zones extends Mage_Core_Model_Mysql4_Abstract {

	public function _construct() {
		$this->_init('swstocklocation/table_zone', 'id');
	}

}

