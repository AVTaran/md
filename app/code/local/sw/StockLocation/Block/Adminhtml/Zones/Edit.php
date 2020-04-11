<?php


class sw_StockLocation_Block_Adminhtml_Zones_Edit extends Mage_Adminhtml_Block_Widget_Form_Container {


	protected function _construct() {
		$this->_blockGroup = 'swstocklocation';
		$this->_controller = 'adminhtml_zones';
	}



	public function getHeaderText() {
		$helper = Mage::helper('swstocklocation');
		$model = Mage::registry('current_zones');

		if ($model->getId()) {
			return $helper->__("Edit zone item '%s'", $this->escapeHtml($model->getName()));
		} else {
			return $helper->__("Add zone item");
		}
	}



}




