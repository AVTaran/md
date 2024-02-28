<?php


class sw_StockLocation_Block_Adminhtml_Locations_Edit_Form extends Mage_Adminhtml_Block_Widget_Form {

	protected function _prepareForm() {

		$helper = Mage::helper('swstocklocation');
		$model = Mage::registry('current_locations');

		$form = new Varien_Data_Form(array(
			'id' => 'edit_form',
			'action' => $this->getUrl('*/*/save', array(
				'id' => $this->getRequest()->getParam('id')
			)),
			'method' => 'post',
			'enctype' => 'multipart/form-data'
		));

		$this->setForm($form);

		$fieldset = $form->addFieldset('locations_form', array('legend' => $helper->__('Locations information')));

		$fieldset->addField('id_zone', 'select', array(
			'label' => $helper->__('Zone'),
			'name' => 'id_zone',
			'values' => $helper->getObjectOptions('zones'),
		));
		$fieldset->addField('id_block', 'select', array(
			'label' => $helper->__('Block'),
			'name' => 'id_block',
			'values' => $helper->getObjectOptions('blocks'),
		));
		$fieldset->addField('id_shelf', 'select', array(
			'label' => $helper->__('Shelf'),
			'name' => 'id_shelf',
			'values' => $helper->getObjectOptions('shelfs'),
		));
		$fieldset->addField('id_box', 'select', array(
			'label' => $helper->__('Box'),
			'name' => 'id_box',
			'values' => $helper->getObjectOptions('boxes'),
		));
		
		$fieldset->addField('id_section', 'select', array(
			'label' => $helper->__('Section'),
			'name' => 'id_section',
			'values' => $helper->getObjectOptions('sections'),
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