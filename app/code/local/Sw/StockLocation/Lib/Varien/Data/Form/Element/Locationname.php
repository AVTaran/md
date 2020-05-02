<?php

// class Sw_Stocklocation_Lib_Varien_Data_Form_Element_Apply extends Varien_Data_Form_Element_Multiselect {

class Sw_Stocklocation_Lib_Varien_Data_Form_Element_Locationname extends Varien_Data_Form_Element_Select {


	public function getElementHtml()
	{
		$helper = Mage::helper('swstocklocation');


		$idLocation = 2;
		$html = $helper->getLocationName($idLocation);

		/*
		if ($this->getReadonly()) {
			$elementAttributeHtml = $elementAttributeHtml . ' readonly="readonly"';
		}

		if ($this->getDisabled()) {
			$elementAttributeHtml = $elementAttributeHtml . ' disabled="disabled"';
		}

		$html = '<select onchange="toggleApplyVisibility(this)"' . $elementAttributeHtml . '>'
			. '<option value="0">' . $this->getModeLabels('all'). '</option>'
			. '<option value="1" ' . ($this->getValue()==null ? '' : 'selected') . '>' . $this->getModeLabels('custom'). '</option>'
			. '</select>';

		$html .= parent::getElementHtml();

		$html .= '<br /><br />';
		*/
		return $html;
	}


}