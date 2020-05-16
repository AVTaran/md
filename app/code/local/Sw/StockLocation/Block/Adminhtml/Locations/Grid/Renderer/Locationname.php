<?php

class Sw_StockLocation_Block_Adminhtml_Locations_Grid_Renderer_Locationname
    extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
   // protected $_values;

    public function render(Varien_Object $row) {
		$helper = Mage::helper('swstocklocation');
		$html = $helper->getLocationName($row->getData()['id'], false);
        return $html;
    }
}
