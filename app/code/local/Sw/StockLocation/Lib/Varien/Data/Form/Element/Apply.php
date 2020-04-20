<?php

// class Sw_Stocklocation_Lib_Varien_Data_Form_Element_Apply extends Varien_Data_Form_Element_Multiselect {

class Sw_Stocklocation_Lib_Varien_Data_Form_Element_Apply extends Varien_Data_Form_Element_Select {


	public function getElementHtml()
	{
		$elementAttributeHtml = '';

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
		return $html;
	}

	/**
	 * Dublicate interface of Varien_Data_Form_Element_Abstract::setReadonly
	 *
	 * @param bool $readonly
	 * @param bool $useDisabled
	 * @return Mage_Adminhtml_Block_Catalog_Product_Helper_Form_Apply
	 */
	public function setReadonly($readonly, $useDisabled = false) {
		$this->setData('readonly', $readonly);
		$this->setData('disabled', $useDisabled);
		return $this;
	}

}