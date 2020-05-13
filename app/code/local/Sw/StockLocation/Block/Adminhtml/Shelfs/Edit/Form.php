<?php


class sw_StockLocation_Block_Adminhtml_Shelfs_Edit_Form extends Mage_Adminhtml_Block_Widget_Form {

	protected function _prepareForm() {

		$helper = Mage::helper('swstocklocation');
		$model = Mage::registry('current_shelfs');

		$id = $this->getRequest()->getParam('id');

		$form = new Varien_Data_Form (array(
			'id' => 'edit_form',
			'action' => $this->getUrl('*/*/save', array(
				'id' => $id
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
		$value = 	array('idBlock' => '-1', 'idZone' => '0');
		$values =	array(
			'block' => array('-1'=>'Please select a previous element'),
			'zone'  => array('0' =>'')
		);
		$disabled = array('block' => true, 'zone' => false);
		if ($id) {
			$filterForObjList	= array();
			$disabled['block'] 	= false;
			$value['idBlock'] 	= Mage::getModel('swstocklocation/shelfs')->load($id)->getId_block();

			$values['zone'] 	= $helper->getObjectOptions('zones');
			$value['idZone'] 	= Mage::getModel('swstocklocation/blocks')->load($value['idBlock'])->getId_zone();

			$filterForObjList['block']['id_zone'] 	= array('eq' => $value['idZone']);

			$values['block'] 	= $helper->getObjectOptions('blocks', $filterForObjList['block']);
		}
		$fieldset->addField('id_zone', 'select', array(
			'label' 			=> $helper->__('Zone'),
			'name'				=> 'id_zone',
			'required'			=> true,
			'value'				=> $value['idZone'],
			'values' 			=> $values['zone'],
			'onchange'			=> 'newStockLocation.takeOptionsForSelect(\'id_zone\', \'id_block\');',
			'tabindex' 			=> 1,
			'default'		    => $value['idZone'],
			// 'after_element_html'=>'<a href="'.$urlAjax.'" target="_blank">'.$urlA.'</a>',
		));
		$fieldset->addField('defaultVal_id_block', 'hidden', array(
			'name' 				=> 'defaultVal[id_block]',
			'value'				=> $value['idBlock']
		));
		$fieldset->addField('defaultVal_id_zone', 'hidden', array(
			'name' 				=> 'defaultVal[id_zone]',
			'value'				=> $value['idZone']
		));
		$fieldset->addField('id_block', 'select', array(
			'label' 			=> $helper->__('Block'),
			'name' 				=> 'id_block',
			'required'  		=> true,
			'value'				=> $value['idBlock'],
			'values' 			=> $values['block'],
			'disabled' 			=> $disabled['block'],
		));


		$fieldset->addField('name', 'text', array(
			'label' => $helper->__('Name'),
			'required' => true,
			'name' => 'name',
		));
        $fieldset->addField('length', 'text', array(
            'label' => $helper->__('Length'),
            'required' => false,
            'name' => 'length',
        ));
        $fieldset->addField('width', 'text', array(
            'label' => $helper->__('Width'),
            'required' => false,
            'name' => 'width',
        ));
        $fieldset->addField('height', 'text', array(
            'label' => $helper->__('Height'),
            'required' => false,
            'name' => 'height',
        ));

        $fieldset->addField('sp_x', 'text', array(
            'label' => $helper->__('sp_x'),
            'required' => false,
            'name' => 'sp_x',
        ));
        $fieldset->addField('sp_y', 'text', array(
            'label' => $helper->__('sp_y'),
            'required' => false,
            'name' => 'sp_y',
        ));
        $fieldset->addField('sp_z', 'text', array(
            'label' => $helper->__('sp_z'),
            'required' => false,
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