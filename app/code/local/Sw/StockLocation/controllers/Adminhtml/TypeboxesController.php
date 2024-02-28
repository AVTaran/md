<?php


class Sw_StockLocation_Adminhtml_TypeboxesController extends Mage_Adminhtml_Controller_Action {




	public function indexAction() {
		$this->loadLayout()->_setActiveMenu('swstocklocation');
		$this->_addContent($this->getLayout()->createBlock('swstocklocation/adminhtml_typeboxes'));
		$this->renderLayout();
	}


	public function newAction() {
		$this->_forward('edit');
	}


	public function editAction() { 
		$id = (int)$this->getRequest()->getParam('id');
		Mage::register('current_typeboxes', Mage::getModel('swstocklocation/typeboxes')->load($id));
		$this->loadLayout();
		$this->_setActiveMenu('swstocklocation');
		$this->_addContent($this->getLayout()->createBlock('swstocklocation/adminhtml_typeboxes_edit'));
		$this->renderLayout();
	}



	public function saveAction() {

		if ($data = $this->getRequest()->getPost()) {
			try {
				$model = Mage::getModel('swstocklocation/typeboxes');
				$model->setData($data)->setId($this->getRequest()->getParam('id'));
				if(!$model->getCreated()){
					$model->setCreated(now());
				}
				$model->save();

				Mage::getSingleton('adminhtml/session')->addSuccess($this->__('Type of box was saved successfully'));
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
				Mage::getModel('swstocklocation/typeboxes')->setId($id)->delete();
				Mage::getSingleton('adminhtml/session')->addSuccess($this->__('Type of box was deleted successfully'));

			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $id));
			}
		}
		$this->_redirect('*/*/');
	}


	public function massDeleteAction() {

		$typeboxes = $this->getRequest()->getParam('typeboxes', null);

		if (is_array($typeboxes) && sizeof($typeboxes) > 0) {
			try {
				foreach ($typeboxes as $id) {
					Mage::getModel('swstocklocation/typeboxes')->setId($id)->delete();
				}
				$this->_getSession()->addSuccess($this->__('Total of %d typeboxes have been deleted', sizeof($typeboxes)));
			} catch (Exception $e) {
				$this->_getSession()->addError($e->getMessage());
			}
		} else {
			$this->_getSession()->addError($this->__('Please select typeboxes'));
		}
		$this->_redirect('*/*');
	}

}


/* */

