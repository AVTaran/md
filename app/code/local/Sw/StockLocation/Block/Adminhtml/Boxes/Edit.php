<?php


class sw_StockLocation_Block_Adminhtml_Boxes_Edit extends Mage_Adminhtml_Block_Widget_Form_Container {


	protected function _construct() {
		$this->_blockGroup = 'swstocklocation';
		$this->_controller = 'adminhtml_boxes';
	}



	public function getHeaderText() {
		$helper = Mage::helper('swstocklocation');
		$model = Mage::registry('current_boxes');

		if ($model->getId()) {
			return $helper->__("Edit box parametrs '%s'", $this->escapeHtml($model->getName()));
		} else {
			return $helper->__("Add box parametrs");
		}
	}



}




