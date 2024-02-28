<?php

class Sw_Stocklocation_Lib_Varien_Data_Form_Element_Hidden extends Varien_Data_Form_Element_Abstract {


	public function __construct($attributes=array())
	{
		parent::__construct($attributes);
		$this->setType('hidden');
		$this->setExtType('hiddenfield');

		if (isset($attributes['value'])) {
			$this->setVal($attributes['value']);
		}
	}

	public function getDefaultHtml()
	{
		$html = $this->getData('default_html');
		if (is_null($html)) {
			$html = $this->getElementHtml();
		}
		return $html;
	}

	public function getElementHtml()
	{
		$html = '<input type="hidden"
					id="'.$this->getHtmlId().'" 
					name="'.$this->getName().'" 
					value="'.$this->getVal().'"
				>'
		;
		return $html;
	}

}