<?php


class sw_StockLocation_Block_Adminhtml_Shelfs_Edit_Form extends Mage_Adminhtml_Block_Widget_Form {

	protected function _prepareForm() {

		$helper = Mage::helper('swstocklocation');
		$model = Mage::registry('current_shelfs');

		$form = new Varien_Data_Form(array(
			'id' => 'edit_form',
			'action' => $this->getUrl('*/*/save', array(
				'id' => $this->getRequest()->getParam('id')
			)),
			'method' => 'post',
			'enctype' => 'multipart/form-data'
		));

		$this->setForm($form);

		$fieldset = $form->addFieldset('shelfs_form', array('legend' => $helper->__('Shelf\'s Information')));


		$fieldset->addField('id_block', 'select', array(
			'label' => $helper->__('Block'),
			'name' => 'id_block',
			'values' => $helper->getObjectOptions('blocks'),
		));

		//		$zones1 = array(
		//			array('value'=>'cms','label'=>'Show in CMS Pages'),
		//			array('value'=>'category','label'=>'Show in All Category pages'),
		//			array('value'=>'product','label'=>'Show in All Product pages'),
		//			array('value'=>'other','label'=>'Show in other pages (cart, checkout, myaccount)'),
		//		);
		//		$zones = $helper->getObjectOptions('zones');
		//		$fieldset->addType('apply','Sw_Stocklocation_Lib_Varien_Data_Form_Element_Apply');
		//		$fieldset->addField('apply_to', 'apply', array(
		//			'name'        => 'apply_to[]',
		//			'label'       => $helper->__('Block'),
		//			'values' 	  => $zones1,
		//			'mode_labels' => array(
		//				'all'     => $helper->__('All Pages'),
		//				'custom'  => $helper->__('Selected Pages')
		//			),
		//			'required'    => true
		//		), 'frontend_class');
		//		$fieldset->addField('name', 'text', array(
		//			'label' => $helper->__('Name'),
		//			'required' => true,
		//			'name' => 'name',
		//		));


        $fieldset->addField('length', 'text', array(
            'label' => $helper->__('Length'),
            'required' => true,
            'name' => 'length',
        ));
        $fieldset->addField('width', 'text', array(
            'label' => $helper->__('Width'),
            'required' => true,
            'name' => 'width',
        ));
        $fieldset->addField('height', 'text', array(
            'label' => $helper->__('Height'),
            'required' => true,
            'name' => 'height',
        ));

        $fieldset->addField('sp_x', 'text', array(
            'label' => $helper->__('sp_x'),
            'required' => true,
            'name' => 'sp_x',
        ));
        $fieldset->addField('sp_y', 'text', array(
            'label' => $helper->__('sp_y'),
            'required' => true,
            'name' => 'sp_y',
        ));
        $fieldset->addField('sp_z', 'text', array(
            'label' => $helper->__('sp_z'),
            'required' => true,
            'name' => 'sp_z',
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