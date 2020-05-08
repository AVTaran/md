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

		$fieldset->addType('hidden','Sw_Stocklocation_Lib_Varien_Data_Form_Element_Hidden');
		$urlAjax = Mage::helper('adminhtml')->getUrl('/adminhtml_stocklocation/ajax', ['_secure' => true]);

		$fieldset->addField('urlAjax', 'hidden', array(
			'name' 				=> 'urlAjax',
			'value'				=> $urlAjax
		));

		$fieldset->addField('id_zone', 'select', array(
			'label' 			=> $helper->__('Zone'),
			'name'				=> 'id_zone',
			'required'			=> true,
			'value'				=> '0',
			'values' 			=> $helper->getObjectOptions('zones'),
			// 'onclick'		=> '',
			'onchange'			=> 'newStockLocation.tackeOptionsForSelect(\'id_zone\',\'id_block\');',
			'tabindex' 			=> 1,
			// 'after_element_html'=>'<a href="'.$urlAjax.'" target="_blank">'.$urlA.'</a>',
		));

		$fieldset->addField('id_block', 'select', array(
			'label' 			=> $helper->__('Block'),
			'name' 				=> 'id_block',
			'required'  		=> true,
			'value'				=> '-1',
			'values' 			=> array('-1'=>'Please select a previous element'), // $helper->getObjectOptions
			//('blocks'),
			// 'after_element_html' => '<small>Comments</small>',
			'disabled' 			=> true,
		));

//		$fieldset->addField('select', 'select', array(
//			'label'     => Mage::helper('form')->__('Select'),
//			'class'     => 'required-entry',
//			'required'  => true,
//			'name'      => 'title',
//			'onclick' => "",
//			'onchange' => "",
//			'value'  => '1',
//			'values' => array('-1'=>'Please Select..','1' => 'Option1','2' => 'Option2', '3' => 'Option3'),
//			'disabled' => false,
//			'readonly' => false,
//			'after_element_html' => '<small>Comments</small>',
//			'tabindex' => 1
//		));
//
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
//			'values' 	  => $helper->getObjectOptions('blocks'),
//			'mode_labels' => array(
//				'all'     => $helper->__('All Pages'),
//				'custom'  => $helper->__('Selected Pages')
//			),
//			'required'    => true
//		), 'frontend_class');

		$fieldset->addField('name', 'text', array(
			'label' => $helper->__('Name'),
			'required' => true,
			'name' => 'name',
		));
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