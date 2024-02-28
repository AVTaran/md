<?php


class Sw_StockLocation_Adminhtml_StockLocationController extends Mage_Adminhtml_Controller_Action {

	public function indexAction() {
		$this->loadLayout();
		$this->_setActiveMenu('swstocklocation');
        $helper = Mage::helper('swstocklocation');

        $this->_headerText = $helper->__('StockLocation: Admin section');

        $contentBlock = $this->getLayout()->createBlock('swstocklocation/adminhtml_stocklocation');
        $this->_addContent($contentBlock);

		$this->renderLayout();
	}

	public function productsViewedAction() {
        $this->loadLayout();
        $this->_setActiveMenu('swstocklocation');
        $this->renderLayout();
    }

	public function AjaxAction(){
		$this->loadLayout();
		$helper = Mage::helper('swstocklocation');
		$contentBlock = $this->getLayout()->createBlock('swstocklocation/adminhtml_ajax')->toHtml();
		// $this->_addContent($contentBlock);
		echo $contentBlock;
	}

}

