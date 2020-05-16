<?php

class Sw_StockLocation_Block_Adminhtml_Locations_Grid_Renderer_Locationdimensions
	extends	Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract {

    public function render(Varien_Object $row) {
		$html = '';
    	$helper = Mage::helper('swstocklocation');
		$dimensions = $helper->getLocationSize($row->getData()['id']);

		if (count($dimensions)>0) {
			$strDimensions = implode('x', $dimensions);
			$strDimensions = str_replace('xx', '', $strDimensions);

			if ($strDimensions!='') {
				$volume = array_product($dimensions);
				$html = round($volume/1000, 2).' <small>('.$strDimensions.')</small>';
			}

		}

        return $html;
    }
}
