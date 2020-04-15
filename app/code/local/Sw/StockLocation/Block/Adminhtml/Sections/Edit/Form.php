<?php


class sw_StockLocation_Block_Adminhtml_Sections_Edit_Form extends Mage_Adminhtml_Block_Widget_Form {

	protected function _prepareForm() {

		$helper = Mage::helper('swstocklocation');
		$model = Mage::registry('current_sections');

		$form = new Varien_Data_Form(array(
			'id' => 'edit_form',
			'action' => $this->getUrl('*/*/save', array(
				'id' => $this->getRequest()->getParam('id')
			)),
			'method' => 'post',
			'enctype' => 'multipart/form-data'
		));

		$this->setForm($form);

		$fieldset = $form->addFieldset('sections_form', array('legend' => $helper->__('Section\'s Information')));

		$fieldset->addField('id_box', 'select', array(
			'label' => $helper->__('Box'),
			'name' => 'id_box',
			'values' => $helper->getObjectOptions('boxes'),
		));
		$fieldset->addField('name', 'text', array(
			'label' => $helper->__('Name'),
			'required' => true,
			'name' => 'name',
		));
		$fieldset->addField('coordinates', 'text', array(
			'label' => $helper->__('Coordinates'),
			'required' => false,
			'name' => 'coordinates',
		));
		$fieldset->addField('dimensions', 'text', array(
			'label' => $helper->__('Dimensions'),
			'required' => false,
			'name' => 'dimensions',
		));


		//$fieldset->addField('created', 'date', array(
			//'format' => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
			//'image' => $this->getSkinUrl('images/grid-cal.gif'),
			//'label' => $helper->__('Created'),
			//'name' => 'created'
		//));

		$form->setUseContainer(true);

		if($data = Mage::getSingleton('adminhtml/session')->getFormData()){
			$form->setValues($data);
		} else {
			$form->setValues($model->getData());
		}

		return parent::_prepareForm();
	}

}