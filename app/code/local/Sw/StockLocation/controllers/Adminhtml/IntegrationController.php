<?php


class Sw_StockLocation_Adminhtml_IntegrationController extends Mage_Adminhtml_Controller_Action {

	public function indexAction() {
		$this->loadLayout();
		$this->_setActiveMenu('swstocklocation');

        $helper = Mage::helper('swstocklocation');
        $this->_headerText = $helper->__('Integration in system');

		$this->getLayout()->getBlock('head')->addItem('skin_js', 'Sw_StockLocation/adminhtml/integration.js');
		// $this->getLayout()->getBlock('head')->addItem('skin_css', 'Sw_StockLocation/adminhtml/integration.css');

        $contentBlock = $this->getLayout()->createBlock('swstocklocation/adminhtml_integration');
        $this->_addContent($contentBlock);

		$this->renderLayout();
	}

	public function AjaxAction(){
		$this->loadLayout();
		$helper = Mage::helper('swstocklocation');
		$contentBlock = $this->getLayout()->createBlock('swstocklocation/adminhtml_integration_ajax')->toHtml();
		// $this->_addContent($contentBlock);
		echo $contentBlock;
	}

}


