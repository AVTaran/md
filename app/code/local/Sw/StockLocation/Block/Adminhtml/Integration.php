<?php


class Sw_StockLocation_Block_Adminhtml_Integration extends Mage_Adminhtml_Block_Abstract
{

    public function __construct() {
        parent::__construct();
		$this->setTemplate('swstocklocation/integration.phtml');
	}


    protected function _prepareLayout() {

		$this->setChild('offwego_button',
			$this->getLayout()->createBlock('adminhtml/widget_button')
				->setData(array(
					'label' 		=> Mage::helper('customer')->__('Off we go'),
					'id' 			=> 'offwego_button',
					'name' 			=> 'offwego_button',
					'element_name' 	=> 'offwego_button',
					// 'disabled' 	=> false,
					'class' 		=> 'offwego_button',
					'onclick' 		=> 'integration.OffWeGo()'
				))
		);

		$this->setChild('size_button',
			$this->getLayout()->createBlock('adminhtml/widget_button')
				->setData(array(
					'label' 		=> Mage::helper('customer')->__('Let\'s count sizes'),
					'id' 			=> 'size_button',
					'name' 			=> 'size_button',
					'element_name' 	=> 'size_button',
					// 'disabled' 	=> false,
					'class' 		=> 'size_button',
					'onclick' 		=> 'integration.countSizeOfLocations()'
				))
		);

        parent::_prepareLayout();
    }


	public function getUrlControllerAdmin()	{
    	$url = $this->getUrl('swstocklocation_admin/adminhtml_integration/ajax'/*, array('ajax'=>1)*/);
		return $url;
	}

}

