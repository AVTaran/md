<?php


class sw_StockLocation_Block_Adminhtml_Sections_Edit extends Mage_Adminhtml_Block_Widget_Form_Container {


	protected function _construct() {
		$this->_blockGroup = 'swstocklocation';
		$this->_controller = 'adminhtml_sections';
	}



	public function getHeaderText() {
		$helper = Mage::helper('swstocklocation');
		$model = Mage::registry('current_sections');

		if ($model->getId()) {
			return $helper->__("Edit section's parametrs '%s'", $this->escapeHtml($model->getName()));
		} else {
			return $helper->__("Add section's parametrs");
		}
	}



}




