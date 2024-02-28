<?php


class Sw_StockLocation_Block_Adminhtml_Search_SearchForm extends  Mage_Adminhtml_Block_Abstract {

    protected function _construct() {
        parent::_construct();
		$this->setTemplate('swstocklocation/search_form.phtml');
    }

}
