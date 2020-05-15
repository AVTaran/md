<?php


class Sw_StockLocation_Adminhtml_SectionsController extends Mage_Adminhtml_Controller_Action {


	public function indexAction() {
		// die('d');
		$this->loadLayout()->_setActiveMenu('swstocklocation');
		//print_r('indexAction');
		$this->_addContent($this->getLayout()->createBlock('swstocklocation/adminhtml_sections'));
		$this->renderLayout();
	}


	public function newAction() {
		$this->_forward('edit');
	}

	public function editAction() { 
		$id = (int)$this->getRequest()->getParam('id');
		Mage::register('current_sections', Mage::getModel('swstocklocation/sections')->load($id));
		$this->loadLayout();
		$this->_setActiveMenu('swstocklocation');
		$this->getLayout()->getBlock('head')->addItem('skin_js', 'Sw_StockLocation/adminhtml/stocklocation.js');
		$this->_addContent($this->getLayout()->createBlock('swstocklocation/adminhtml_sections_edit'));
		$this->renderLayout();
	}



	public function saveAction() {

		if ($data = $this->getRequest()->getPost()) {
			try {
				$model = Mage::getModel('swstocklocation/sections');
				$model->setData($data)->setId($this->getRequest()->getParam('id'));
				if(!$model->getCreated()){
					$model->setCreated(now());
				}
				$model->save();

				Mage::getSingleton('adminhtml/session')->addSuccess($this->__('Sections was saved successfully'));
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
				Mage::getModel('swstocklocation/sections')->setId($id)->delete();
				Mage::getSingleton('adminhtml/session')->addSuccess($this->__('Sections was deleted successfully'));
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $id));
			}
		}
		$this->_redirect('*/*/');
	}



	public function massDeleteAction() {

		$sections = $this->getRequest()->getParam('sections', null);

		if (is_array($sections) && sizeof($sections) > 0) {
			try {
				foreach ($sections as $id) {
					Mage::getModel('swstocklocation/sections')->setId($id)->delete();
				}
				$this->_getSession()->addSuccess($this->__('Total of %d sections have been deleted', sizeof($sections)));
			} catch (Exception $e) {
				$this->_getSession()->addError($e->getMessage());
			}
		} else {
			$this->_getSession()->addError($this->__('Please select sections'));
		}
		$this->_redirect('*/*');
	}


}

