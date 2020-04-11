<?php

class Sw_StockLocation_Model_Resource_Blocks extends Mage_Core_Model_Mysql4_Abstract {

	public function _construct() {
		$this->_init('swstocklocation/table_block', 'id');
		// $this->_init('swstocklocation/table_zone', 'id');
	}

}

