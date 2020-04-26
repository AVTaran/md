<?php


class Sw_StockLocation_Adminhtml_NewlocationController extends Mage_Adminhtml_Controller_Action {

	public function indexAction() {
		$this->loadLayout();
		$this->_setActiveMenu('swstocklocation');
        $helper = Mage::helper('swstocklocation');

        $this->_headerText = $helper->__('New location for product');

		// echo '<h1>StockLocation: Admin section</h1>';

		$this->getLayout()->getBlock('head')->addItem('skin_js', 'Sw_StockLocation/adminhtml/newlocation.js');
		$this->getLayout()->getBlock('head')->addItem('skin_css', 'Sw_StockLocation/adminhtml/newlocation.css');

        $contentBlock = $this->getLayout()->createBlock('swstocklocation/adminhtml_newlocation');

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
		$contentBlock = $this->getLayout()->createBlock('swstocklocation/adminhtml_newlocation_ajax')->toHtml();
		// $this->_addContent($contentBlock);
		echo $contentBlock;
	}

}


