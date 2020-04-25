<?php


class sw_StockLocation_Block_Adminhtml_Sizelocation_Edit_Form extends Mage_Adminhtml_Block_Widget_Form {

	protected function _prepareForm() {

		$helper = Mage::helper('swstocklocation');
		$model = Mage::registry('current_sizelocation');

		$form = new Varien_Data_Form(array(
			'id' => 'edit_form',
			'action' => $this->getUrl('*/*/save', array(
				'id' => $this->getRequest()->getParam('id')
			)),
			'method' => 'post',
			'enctype' => 'multipart/form-data'
		));

		$this->setForm($form);

		$fieldset = $form->addFieldset('sizelocation_form', array('legend' => $helper->__('Type of box information')));

		$fieldset->addField('name', 'text', array(
			'label' => $helper->__('Name'),
			'required' => true,
			'name' => 'name',
		));
		$fieldset->addField('volume', 'text', array(
			'label' => $helper->__('Volume'),
			'required' => true,
			'name' => 'volume',
		));
		$fieldset->addField('description', 'text', array(
			'label' => $helper->__('Description'),
			'required' => false,
			'name' => 'description',
		));

		$form->setUseContainer(true);

		if($data = Mage::getSingleton('adminhtml/session')->getFormData()){
			$form->setValues($data);
		} else {
			$form->setValues($model->getData());
		}

		return parent::_prepareForm();
	}

}