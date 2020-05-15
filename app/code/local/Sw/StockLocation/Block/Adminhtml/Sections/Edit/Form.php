<?php


class sw_StockLocation_Block_Adminhtml_Sections_Edit_Form extends Mage_Adminhtml_Block_Widget_Form {

	protected function _prepareForm() {

		$helper = Mage::helper('swstocklocation');
		$model = Mage::registry('current_sections');

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
		$fieldset = $form->addFieldset('sections_form', array('legend' => $helper->__('Section\'s Information')));

		$fieldset->addType('hidden','Sw_Stocklocation_Lib_Varien_Data_Form_Element_Hidden');
		$urlAjax = Mage::helper('adminhtml')->getUrl('/adminhtml_stocklocation/ajax', ['_secure' => true]);
		$fieldset->addField('urlAjax', 'hidden', array(
			'name' 		=> 'urlAjax',
			'value'		=> $urlAjax
		));

		$value = 	array(
			'idZone'  	=> '0',
			'idBlock'	=> '-1',
			'idShelf'	=> '-1',
			'idBox' 	=> '-1',
		);
		$values =	array(
			'zone'  	=> array('0' =>''),
			'block'		=> array('-1'=>'Please select a previous element'),
			'shelf' 	=> array('-1'=>'Please select a previous element'),
			'box'		=> array('-1'=>'Please select a previous element'),
		);
		$disabled = array(
			'zone' 		=> true,
			'block' 	=> false,
			'shelf' 	=> false,
			'box' 		=> false
		);
		if ($id) {
			$filterForObjList	= array();

			$disabled['box'] 	= false;
			$value['idBox'] 	= Mage::getModel('swstocklocation/sections')->load($id)->getId_box();

			$disabled['shelf'] 	= false;
			$value['idShelf'] 	= Mage::getModel('swstocklocation/boxes')->load($value['idBox'])->getId_shelf();

			$disabled['block'] 	= false;
			$value['idBlock'] 	= Mage::getModel('swstocklocation/shelfs')->load($value['idShelf'])->getId_block();

			$values['zone'] 	= $helper->getObjectOptions('zones');
			$value['idZone'] 	= Mage::getModel('swstocklocation/blocks')->load($value['idBlock'])->getId_zone();

			$filterForObjList['blocks']['id_zone'] 	= array('eq' => $value['idZone']);
			$values['block'] 	= $helper->getObjectOptions('blocks', $filterForObjList);

			$filterForObjList['shelfs']['id_block'] = array('eq' => $value['idBlock']);
			$values['shelf'] 	= $helper->getObjectOptions('shelfs', $filterForObjList);

			$filterForObjList['boxes']['id_shelf'] = array('eq' => $value['idShelf']);
			$values['box'] 		= $helper->getObjectOptions('boxes', $filterForObjList);
		}

		$fieldset->addField('defaultVal_id_zone', 'hidden', array(
			'name' 				=> 'defaultVal[id_zone]',
			'value'				=> $value['idZone']
		));
		$arObjOptions = array(
			array('obj'=>'id_zone',  'target'=>'id_block'),
			array('obj'=>'id_block', 'target'=>'id_shelf'),
			array('obj'=>'id_shelf', 'target'=>'id_box'),
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
		));
		$arObjOptions = array(
			array('obj'=>'id_block', 'target'=>'id_shelf'),
			array('obj'=>'id_shelf', 'target'=>'id_box'),
		);
		$arObjOptions = base64_encode(json_encode($arObjOptions));
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
			'onchange'			=> 'newStockLocation.changeOptions(\''.$arObjOptions.'\', \'id_block\');',
			'disabled' 			=> $disabled['block'],
		));
		$arObjOptions = array(
			array('obj'=>'id_shelf', 'target'=>'id_box'),
		);
		$arObjOptions = base64_encode(json_encode($arObjOptions));
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
			'onchange'			=> 'newStockLocation.changeOptions(\''.$arObjOptions.'\', \'id_block\');',
			'disabled' 			=> $disabled['shelf'],
		));
		$fieldset->addField('defaultVal_id_box', 'hidden', array(
			'name' 				=> 'defaultVal[id_box]',
			'value'				=> $value['idBox']
		));
		$fieldset->addField('id_box', 'select', array(
			'label' 			=> $helper->__('Box'),
			'name' 				=> 'id_box',
			'required'  		=> true,
			'value'				=> $value['idBox'],
			'values' 			=> $values['box'],
			'disabled' 			=> $disabled['box'],
		));

		$fieldset->addField('name', 'text', array(
			'label' 			=> $helper->__('Name'),
			'required' 			=> true,
			'name' 				=> 'name',
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

		$form->setUseContainer(true);

		if($data = Mage::getSingleton('adminhtml/session')->getFormData()){
			$form->setValues($data);
		} else {
			$form->setValues($model->getData());
		}

		return parent::_prepareForm();
	}

}