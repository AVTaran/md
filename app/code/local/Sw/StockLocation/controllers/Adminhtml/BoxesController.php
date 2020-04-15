<?php


class Sw_StockLocation_Adminhtml_BoxesController extends Mage_Adminhtml_Controller_Action {


	public function indexAction() {
		// die('d');
		$this->loadLayout()->_setActiveMenu('swstocklocation');
		//print_r('indexAction');
		$this->_addContent($this->getLayout()->createBlock('swstocklocation/adminhtml_boxes'));
		$this->renderLayout();
	}


	public function newAction() {
		$this->_forward('edit');
	}

	public function editAction() { 
		$id = (int)$this->getRequest()->getParam('id');
		Mage::register('current_boxes', Mage::getModel('swstocklocation/boxes')->load($id));
		$this->loadLayout();
		$this->_setActiveMenu('swstocklocation');
		$this->_addContent($this->getLayout()->createBlock('swstocklocation/adminhtml_boxes_edit'));
		$this->renderLayout();
	}



	public function saveAction() {

		if ($data = $this->getRequest()->getPost()) {
			try {
				$model = Mage::getModel('swstocklocation/boxes');
				$model->setData($data)->setId($this->getRequest()->getParam('id'));
				if(!$model->getCreated()){
					$model->setCreated(now());
				}
				$model->save();

				Mage::getSingleton('adminhtml/session')->addSuccess($this->__('Boxes was saved successfully'));
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
				Mage::getModel('swstocklocation/boxes')->setId($id)->delete();
				Mage::getSingleton('adminhtml/session')->addSuccess($this->__('Boxes was deleted successfully'));
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $id));
			}
		}
		$this->_redirect('*/*/');
	}



	public function massDeleteAction() {

		$boxes = $this->getRequest()->getParam('boxes', null);

		if (is_array($boxes) && sizeof($boxes) > 0) {
			try {
				foreach ($boxes as $id) {
					Mage::getModel('swstocklocation/boxes')->setId($id)->delete();
				}
				$this->_getSession()->addSuccess($this->__('Total of %d boxes have been deleted', sizeof($boxes)));
			} catch (Exception $e) {
				$this->_getSession()->addError($e->getMessage());
			}
		} else {
			$this->_getSession()->addError($this->__('Please select boxes'));
		}
		$this->_redirect('*/*');
	}


}

