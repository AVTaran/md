<?php


class Sw_StockLocation_Adminhtml_LocationsController extends Mage_Adminhtml_Controller_Action {


	public function indexAction() {
		$this->loadLayout()->_setActiveMenu('swstocklocation');
		$this->_addContent($this->getLayout()->createBlock('swstocklocation/adminhtml_locations'));
		$this->renderLayout();
	}


	public function newAction() {
		$this->_forward('edit');
	}


	public function editAction() { 
		$id = (int)$this->getRequest()->getParam('id');
		Mage::register('current_locations', Mage::getModel('swstocklocation/locations')->load($id));
		$this->loadLayout();
		$this->_setActiveMenu('swstocklocation');
		$this->_addContent($this->getLayout()->createBlock('swstocklocation/adminhtml_locations_edit'));
		$this->renderLayout();
	}



	public function saveAction() {

		if ($data = $this->getRequest()->getPost()) {
			try {
				$model = Mage::getModel('swstocklocation/locations');
				$model->setData($data)->setId($this->getRequest()->getParam('id'));
				if(!$model->getCreated()){
					$model->setCreated(now());
				}
				$model->save();

				Mage::getSingleton('adminhtml/session')->addSuccess($this->__('Location was saved successfully'));
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
				Mage::getModel('swstocklocation/locations')->setId($id)->delete();
				Mage::getSingleton('adminhtml/session')->addSuccess($this->__('Locations was deleted successfully'));

			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $id));
			}
		}
		$this->_redirect('*/*/');
	}


	public function massDeleteAction() {

		$locations = $this->getRequest()->getParam('locations', null);

		if (is_array($locations) && sizeof($locations) > 0) {
			try {
				foreach ($locations as $id) {
					Mage::getModel('swstocklocation/locations')->setId($id)->delete();
				}
				$this->_getSession()->addSuccess($this->__('Total of %d locations have been deleted', sizeof($locations)));
			} catch (Exception $e) {
				$this->_getSession()->addError($e->getMessage());
			}
		} else {
			$this->_getSession()->addError($this->__('Please select locations'));
		}
		$this->_redirect('*/*');
	}

}


/* */

