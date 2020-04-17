<?php


class Sw_StockLocation_Adminhtml_StockLocationController extends Mage_Adminhtml_Controller_Action {

	public function indexAction() {
		$this->loadLayout();
		$this->_setActiveMenu('swstocklocation');
        $helper = Mage::helper('swstocklocation');

        $this->_headerText = $helper->__('StockLocation: Admin section');

		// echo '<h1>StockLocation: Admin section</h1>';

		$this->getLayout()->getBlock('head')->addItem('skin_js', 'Sw_StockLocation/adminhtml/scripts.js');
		$this->getLayout()->getBlock('head')->addItem('skin_css', 'Sw_StockLocation/adminhtml/styles.css');

        $contentBlock = $this->getLayout()->createBlock('swstocklocation/adminhtml_stocklocation');
        $this->_addContent($contentBlock);



		$this->renderLayout();
	}

	public function productsViewedAction() {
        $this->loadLayout();
        $this->_setActiveMenu('swstocklocation');
        $this->renderLayout();
    }

	public function zonesAction() {
		$this->loadLayout();
		$this->_setActiveMenu('swstocklocation');
		// print_r('zones');

		$contentBlock = $this->getLayout()->createBlock('swstocklocation/adminhtml_zones');
		$this->_addContent($contentBlock);

		$this->renderLayout();
	}


	public function blocksAction() {
		$this->loadLayout();
		$this->_setActiveMenu('swstocklocation');
		// print_r('blocks');

		$contentBlock = $this->getLayout()->createBlock('swstocklocation/adminhtml_blocks');
		$this->_addContent($contentBlock);

		$this->renderLayout();
	}


	public function shelfsAction() {
		$this->loadLayout();
		$this->_setActiveMenu('swstocklocation');
		// print_r('shelfs');

		$this->renderLayout();
	}

	public function boxsAction() {

		$this->loadLayout();
		print_r('boxs');
		$this->renderLayout();
	}

	public function sectionsAction() {

		$this->loadLayout();
		print_r('section');
		$this->renderLayout();
	}


	//public function massDeleteAction() {

		//$zones = $this->getRequest()->getParam('zones', null);

		//if (is_array($zones) && sizeof($zones) > 0) {
			//try {
				//foreach ($zones as $id) {
					//Mage::getModel('swstocklocation/zones')->setId($id)->delete();
				//}
				//$this->_getSession()->addSuccess($this->__('Total of %d zones have been deleted', sizeof($zones)));
			//} catch (Exception $e) {
				//$this->_getSession()->addError($e->getMessage());
			//}
		//} else {
			//$this->_getSession()->addError($this->__('Please select zones'));
		//}
		//$this->_redirect('*/*');
	//}


}

/* */

