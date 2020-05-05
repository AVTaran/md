<?php

class Sw_StockLocation_Helper_Data extends Mage_Core_Helper_Abstract {

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

		// a default option
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


	public function getLocationName ($idLocation) {
		$locationName = '';

		$ObjLocation = Mage::getModel('swstocklocation/locations')->load($idLocation);
		$rawLocationData = $ObjLocation->toArray();

		if (!is_null($rawLocationData['id_zone']) AND $rawLocationData['id_zone']>0) {
			$zoneName = Mage::getModel('swstocklocation/zones')
				->load($rawLocationData['id_zone'])
				->getName()
			;
			$locationName .= $zoneName;
		}
		if (!is_null($rawLocationData['id_block']) AND $rawLocationData['id_block']>0) {
			$blockName = Mage::getModel('swstocklocation/blocks')
				->load($rawLocationData['id_block'])
				->getName()
			;
			$locationName .= $blockName;
		}
		if (!is_null($rawLocationData['id_shelf']) AND $rawLocationData['id_shelf']>0) {
			$shelfName = Mage::getModel('swstocklocation/shelfs')
				->load($rawLocationData['id_shelf'])
				->getName()
			;
			$locationName .= '-'.$shelfName;
		}
		if (!is_null($rawLocationData['id_box']) AND $rawLocationData['id_box']>0) {
			$boxName = Mage::getModel('swstocklocation/boxes')
				->load($rawLocationData['id_box'])
				->getName()
			;
			$locationName .= '/'.$boxName;
		}
		if (!is_null($rawLocationData['id_section']) AND $rawLocationData['id_section']>0) {
			$sectionName = Mage::getModel('swstocklocation/sections')
				->load($rawLocationData['id_section'])
				->getName()
			;
			$locationName .= $sectionName;
		}

		$locationName .= ' ('.implode('x', $this->getLocationSize($idLocation)).')';

		return $locationName;
	}


	public function getLocationSize ($idLocation, $approx=true) {
		$length = $width = $height = $dimensions = null;

		$ObjLocation = Mage::getModel('swstocklocation/locations')->load($idLocation);
		$rawLocationData = $ObjLocation->toArray();

		if (!is_null($rawLocationData['id_zone']) AND $rawLocationData['id_zone']>0) {
			$objZone = Mage::getModel('swstocklocation/zones')->load($rawLocationData['id_zone']);
			$length 	= $objZone->getLength();
			$width 		= $objZone->getWidth();
			$height 	= $objZone->getHeight();
			$dimensions = $objZone->getDimensions();
		}
		if (!is_null($rawLocationData['id_block']) AND $rawLocationData['id_block']>0) {
			$objBlock = Mage::getModel('swstocklocation/blocks')->load($rawLocationData['id_block']);
			$length 	= $objBlock->getLength();
			$width 		= $objBlock->getWidth();
			$height 	= $objBlock->getHeight();
			$dimensions = $objBlock->getDimensions();
		}
		if (!is_null($rawLocationData['id_shelf']) AND $rawLocationData['id_shelf']>0) {
			$objShelf = Mage::getModel('swstocklocation/shelfs')->load($rawLocationData['id_shelf']);
			$length 	= $objShelf->getLength();
			$width 		= $objShelf->getWidth();
			$height 	= $objShelf->getHeight();
			$dimensions = $objShelf->getDimensions();
		}
		if (!is_null($rawLocationData['id_box']) AND $rawLocationData['id_box']>0) {
			$objBox = Mage::getModel('swstocklocation/boxes')->load($rawLocationData['id_box']);
			$length 	= $objBox->getLength();
			$width 		= $objBox->getWidth();
			$height 	= $objBox->getHeight();
			$dimensions = $objBox->getDimensions();
		}
		if (!is_null($rawLocationData['id_section']) AND $rawLocationData['id_section']>0) {
			$objSection = Mage::getModel('swstocklocation/sections')->load($rawLocationData['id_section']);
			$length 	= $objSection->getLength();
			$width 		= $objSection->getWidth();
			$height 	= $objSection->getHeight();
			$dimensions = $objSection->getDimensions();
		}

		$locationSize = array (
			'length'		=> $length,
			'width'			=> $width,
			'height'		=> $height,
			'dimensions' 	=> $dimensions,
		);
		return $locationSize;
	}
}
