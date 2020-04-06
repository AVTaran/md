<?php


class Sw_StockLocation_Adminhtml_ZonesController extends Mage_Adminhtml_Controller_Action {


	public function indexAction() {
		$this->loadLayout()->_setActiveMenu('swstocklocation');
		// print_r('llll');
		$this->_addContent($this->getLayout()->createBlock('swstocklocation/adminhtml_zones'));
		$this->renderLayout();
	}


	public function newAction() {
		$this->_forward('edit');
	}


	public function editAction() { 
		$id = (int) $this->getRequest()->getParam('id');
		Mage::register('current_zones', Mage::getModel('swstocklocation/zones')->load($id));
		$this->loadLayout();
		$this->_setActiveMenu('swstocklocation');
		$this->_addContent($this->getLayout()->createBlock('swstocklocation/adminhtml_zones_edit'));
		$this->renderLayout();
	}



	public function saveAction() {

		if ($data = $this->getRequest()->getPost()) {
			try {
				$model = Mage::getModel('swstocklocation/zones');
				$model->setData($data)->setId($this->getRequest()->getParam('id'));
				if(!$model->getCreated()){
					$model->setCreated(now());
				}
				$model->save();

				Mage::getSingleton('adminhtml/session')->addSuccess($this->__('News was saved successfully'));
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
				Mage::getModel('swstocklocation/zones')->setId($id)->delete();
				Mage::getSingleton('adminhtml/session')->addSuccess($this->__('News was deleted successfully'));
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $id));
			}
		}
		$this->_redirect('*/*/');
	}


	public function massDeleteAction() {

		$zones = $this->getRequest()->getParam('zones', null);

		if (is_array($zones) && sizeof($zones) > 0) {
			try {
				foreach ($zones as $id) {
					Mage::getModel('swstocklocation/zones')->setId($id)->delete();
				}
				$this->_getSession()->addSuccess($this->__('Total of %d zones have been deleted', sizeof($zones)));
			} catch (Exception $e) {
				$this->_getSession()->addError($e->getMessage());
			}
		} else {
			$this->_getSession()->addError($this->__('Please select zones'));
		}
		$this->_redirect('*/*');
	}


}

/* */

