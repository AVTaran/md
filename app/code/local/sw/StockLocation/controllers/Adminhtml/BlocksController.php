<?php


class Sw_StockLocation_Adminhtml_BlocksController extends Mage_Adminhtml_Controller_Action {


	public function indexAction() {
		$this->loadLayout()->_setActiveMenu('swstocklocation');
		$this->_addContent($this->getLayout()->createBlock('swstocklocation/adminhtml_blocks'));
		$this->renderLayout();
	}


	public function newAction() {
		$this->_forward('edit');
	}


	public function editAction() { 
		$id = (int)$this->getRequest()->getParam('id');
		Mage::register('current_blocks', Mage::getModel('swstocklocation/blocks')->load($id));
		$this->loadLayout();
		$this->_setActiveMenu('swstocklocation');


//		$this->getLayout()->getBlock('head')->addItem('skin_js', 'Sw_StockLocation/adminhtml/scripts.js');
//		$this->getLayout()->getBlock('head')->addItem('skin_css', 'Sw_StockLocation/adminhtml/styles.css');


		$this->_addContent($this->getLayout()->createBlock('swstocklocation/adminhtml_blocks_edit'));
		$this->renderLayout();
		


	}



	public function saveAction() {

		if ($data = $this->getRequest()->getPost()) {
			try {
				$model = Mage::getModel('swstocklocation/blocks');
				$model->setData($data)->setId($this->getRequest()->getParam('id'));
				if(!$model->getCreated()){
					$model->setCreated(now());
				}
				$model->save();

				Mage::getSingleton('adminhtml/session')->addSuccess($this->__('Block was saved successfully'));
				Mage::getSingleton('adminhtml/session')->setFormData(false);
				$this->_redirect('*/*/');

			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				Mage::getSingleton('adminhtml/session')->setFormData($data);
				$this->_redirect('*/*/edit', array(
					'id' => $this->getRequest()->getParam('id')
				));
			}
			return;
		}
		Mage::getSingleton('adminhtml/session')->addError($this->__('Unable to find item to save'));
		$this->_redirect('*/*/');
	}



	public function deleteAction() {
		if ($id = $this->getRequest()->getParam('id')) {
			try {
				Mage::getModel('swstocklocation/blocks')->setId($id)->delete();
				Mage::getSingleton('adminhtml/session')->addSuccess($this->__('Blocks was deleted successfully'));

			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $id));
			}
		}
		$this->_redirect('*/*/');
	}


	public function massDeleteAction() {

		$blocks = $this->getRequest()->getParam('blocks', null);

		if (is_array($blocks) && sizeof($blocks) > 0) {
			try {
				foreach ($blocks as $id) {
					Mage::getModel('swstocklocation/blocks')->setId($id)->delete();
				}
				$this->_getSession()->addSuccess($this->__('Total of %d blocks have been deleted', sizeof($blocks)));
			} catch (Exception $e) {
				$this->_getSession()->addError($e->getMessage());
			}
		} else {
			$this->_getSession()->addError($this->__('Please select blocks'));
		}
		$this->_redirect('*/*');
	}


}



