<?php


class sw_StockLocation_Block_Adminhtml_Typeboxes_Edit extends Mage_Adminhtml_Block_Widget_Form_Container {


	protected function _construct() {
		$this->_blockGroup = 'swstocklocation';
		$this->_controller = 'adminhtml_typeboxes';
	}



	public function getHeaderText() {
		$helper = Mage::helper('swstocklocation');
		$model = Mage::registry('current_typeboxes');

		if ($model->getId()) {
			return $helper->__("Edit type of box '%s'", $this->escapeHtml($model->getName()));
		} else {
			return $helper->__("Add type of box");
		}
	}



}




