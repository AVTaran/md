<?php

class Sw_StockLocation_Model_Resource_Locationproduct extends Mage_Core_Model_Mysql4_Abstract {

	public function _construct() {
		$this->_init('swstocklocation/table_location_product', 'id_location');
	}

}

