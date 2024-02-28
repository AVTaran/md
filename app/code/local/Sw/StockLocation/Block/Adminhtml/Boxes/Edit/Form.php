<?php


class sw_StockLocation_Block_Adminhtml_Boxes_Edit_Form extends Mage_Adminhtml_Block_Widget_Form {

	protected function _prepareForm() {

		$helper = Mage::helper('swstocklocation');
		$model = Mage::registry('current_boxes');

		$id = $this->getRequest()->getParam('id');
		$form = new Varien_Data_Form(array(
			'id' => 'edit_form',
			'action' => $this->getUrl('*/*/save', array(
				'id' => $id
			)),
			'method' => 'post',
			'enctype' => 'multipart/form-data'
		));

		$this->setForm($form);
		$fieldset = $form->addFieldset('boxes_form', array('legend' => $helper->__('Box\'s Information')));

		$fieldset->addType('hidden','Sw_Stocklocation_Lib_Varien_Data_Form_Element_Hidden');
		$urlAjax = Mage::helper('adminhtml')->getUrl('/adminhtml_stocklocation/ajax', ['_secure' => true]);
		$fieldset->addField('urlAjax', 'hidden', array(
			'name' 				=> 'urlAjax',
			'value'				=> $urlAjax
		));
		$value = 	array(
			'idZone'  => '0',
			'idBlock' => '-1',
			'idShelf' => '-1',
		);
		$values =	array(
			'zone'  => array('0' =>''),
			'block' => array('-1'=>'Please select a previous element'),
			'shelf' => array('-1'=>'Please select a previous element'),
		);
		$disabled = array(
			'block' => true,
			'zone' 	=> true,
			'shelf' => false
		);
		if ($id) {
			$filterForObjList	= array();

			$disabled['shelf'] 	= false;
			$value['idShelf'] 	= Mage::getModel('swstocklocation/boxes')->load($id)->getId_shelf();

			$disabled['block'] 	= false;
			$value['idBlock'] 	= Mage::getModel('swstocklocation/shelfs')->load($value['idShelf'])->getId_block();

			$values['zone'] 	= $helper->getObjectOptions('zones');
			$value['idZone'] 	= Mage::getModel('swstocklocation/blocks')->load($value['idBlock'])->getId_zone();

			$filterForObjList['blocks']['id_zone'] 	= array('eq' => $value['idZone']);
			$values['block'] 	= $helper->getObjectOptions('blocks', $filterForObjList);

			$filterForObjList['shelfs']['id_block'] = array('eq' => $value['idBlock']);
			$values['shelf'] 	= $helper->getObjectOptions('shelfs', $filterForObjList);
		}

		$fieldset->addField('defaultVal_id_zone', 'hidden', array(
			'name' 				=> 'defaultVal[id_zone]',
			'value'				=> $value['idZone']
		));
		$arObjOptions = array(
			array('obj'=>'id_zone', 'target'=>'id_block'),
			array('obj'=>'id_block', 'target'=>'id_shelf'),
		);
		$arObjOptions = base64_encode(json_encode($arObjOptions));

		$fieldset->addField('id_zone', 'select', array(
			'label' 			=> $helper->__('Zone'),
			'name'				=> 'id_zone',
			'required'			=> true,
			'value'				=> $value['idZone'],
			'values' 			=> $values['zone'],
			'onchange'			=> 'newStockLocation.changeOptions(\''.$arObjOptions.'\', \'id_zone\');',
			'tabindex' 			=> 1,
			'default'		    => $value['idZone'],
			// 'after_element_html'=>'<a href="'.$urlAjax.'" target="_blank">'.$urlA.'</a>',
		));
		$fieldset->addField('defaultVal_id_block', 'hidden', array(
			'name' 				=> 'defaultVal[id_block]',
			'value'				=> $value['idBlock']
		));
		$fieldset->addField('id_block', 'select', array(
			'label' 			=> $helper->__('Block'),
			'name' 				=> 'id_block',
			'required'  		=> true,
			'value'				=> $value['idBlock'],
			'values' 			=> $values['block'],
			'onchange'			=> 'newStockLocation.takeOptionsForSelect(\'id_block\', \'id_shelf\');',
			'disabled' 			=> $disabled['block'],
		));
		$fieldset->addField('defaultVal_id_shelf', 'hidden', array(
			'name' 				=> 'defaultVal[id_shelf]',
			'value'				=> $value['idShelf']
		));
		$fieldset->addField('id_shelf', 'select', array(
			'label' 			=> $helper->__('Shelf'),
			'name' 				=> 'id_shelf',
			'required'  		=> true,
			'value'				=> $value['idShelf'],
			'values' 			=> $values['shelf'],
			'disabled' 			=> $disabled['shelf'],
		));

		$fieldset->addField('name', 'text', array(
			'label' 			=> $helper->__('Name'),
			'required' 			=> true,
			'name' 				=> 'name',
		));
		$fieldset->addField('id_typebox', 'select', array(
			'label'				=> $helper->__('Type of box'),
			'name' 				=> 'id_typebox',
			'values' 			=> $helper->getObjectOptions('typeboxes'),
		));

		$fieldset->addField('length', 'text', array(
			'label' 			=> $helper->__('Length'),
			'required' 			=> false,
			'name' 				=> 'length',
		));
		$fieldset->addField('width', 'text', array(
			'label' 			=> $helper->__('Width'),
			'required' 			=> false,
			'name' 				=> 'width',
		));
		$fieldset->addField('height', 'text', array(
			'label' 			=> $helper->__('Height'),
			'required' 			=> false,
			'name' 				=> 'height',
		));

		$fieldset->addField('sp_x', 'text', array(
			'label' 			=> $helper->__('sp_x'),
			'required' 			=> false,
			'name' 				=> 'sp_x',
		));
		$fieldset->addField('sp_y', 'text', array(
			'label' 			=> $helper->__('sp_y'),
			'required' 			=> false,
			'name' 				=> 'sp_y',
		));
		$fieldset->addField('sp_z', 'text', array(
			'label' 			=> $helper->__('sp_z'),
			'required' 			=> false,
			'name' 				=> 'sp_z',
		));

		$fieldset->addField('approx_length', 'text', array(
			'label' => $helper->__('A. Length'),
			'required' => true,
			'name' => 'approx_length',
		));
		$fieldset->addField('approx_width', 'text', array(
			'label' => $helper->__('A. Width'),
			'required' => true,
			'name' => 'approx_width',
		));
		$fieldset->addField('approx_height', 'text', array(
			'label' => $helper->__('A. Height'),
			'required' => true,
			'name' => 'approx_height',
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