<?php

class Sw_StockLocation_Helper_Data extends Mage_Core_Helper_Abstract {

	//	public function includeJS($nameJS) {
	//		$this->loadLayout();
	//		$this->getLayout()->getBlock('head')->addItem('skin_js', 'Sw_StockLocation/adminhtml/applySelect.js');
	//	}


	public function getObjectList($obj, $fieldId = 'Id', $fieldName = 'Name') {
		$ObjList = Mage::getModel('swstocklocation/'.$obj)->getCollection()->load();
		$output = array();
		foreach($ObjList as $Obj) {
			$id				= $Obj->{'get'.$fieldId}();
			$output[$id]	= $Obj->{'get'.$fieldName}();
		}
		return $output;
	}

	public function getObjectOptions($obj, $fields = array('value'=>'Id', 'label'=>'Name')) {
		$ObjList = Mage::getModel('swstocklocation/'.$obj)->getCollection()->load();
		$options = $anOption = array();

		// default
		foreach ($fields AS $par => $var) {
			$anOption[$par] = '';
		}
		$options[] = $anOption;

		// pairs: parametr-value 
		foreach ($ObjList as $Obj) {
			$anOption = array();
			foreach ($fields AS $par => $var) {
				$anOption[$par] = $Obj->{'get'.$var}();
			}
			$options[] = $anOption;
		}
		return $options;
	}

}
