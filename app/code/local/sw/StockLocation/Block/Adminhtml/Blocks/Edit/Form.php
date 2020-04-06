<?php


class sw_StockLocation_Block_Adminhtml_Blocks_Edit_Form extends Mage_Adminhtml_Block_Widget_Form {

	protected function _prepareForm() {

		$helper = Mage::helper('swstocklocation');
		$model = Mage::registry('current_blocks');

		$form = new Varien_Data_Form(array(
			'id' => 'edit_form',
			'action' => $this->getUrl('*/*/save', array(
				'id' => $this->getRequest()->getParam('id')
			)),
			'method' => 'post',
			'enctype' => 'multipart/form-data'
		));

		$this->setForm($form);

		$fieldset = $form->addFieldset('blocks_form', array('legend' => $helper->__('News Information')));

		//$fieldset->addField('name', 'text', array(
			//'label' => $helper->__('Name'),
			//'required' => true,
			//'name' => 'name',
		//));

		//$fieldset->addField('coordinates', 'text', array(
			//'label' => $helper->__('Coordinates'),
			//'required' => false,
			//'name' => 'coordinates',
		//));

		//$fieldset->addField('dimensions', 'text', array(
			//'label' => $helper->__('Dimensions'),
			//'required' => false,
			//'name' => 'dimensions',
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