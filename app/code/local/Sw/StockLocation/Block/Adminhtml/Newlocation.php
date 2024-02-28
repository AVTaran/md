<?php


class Sw_StockLocation_Block_Adminhtml_Newlocation extends Mage_Adminhtml_Block_Abstract
{

    public function __construct() {
        parent::__construct();
		$this->setTemplate('swstocklocation/newlocation.phtml');
	}


    protected function _prepareLayout() {

		$this->setChild('filter',
			$this->getLayout()->createBlock('swstocklocation/adminhtml_newlocation_filter')
		);


		$this->setChild('search_button',
			$this->getLayout()->createBlock('adminhtml/widget_button')
				->setData(array(
					'label' => Mage::helper('customer')->__('Find'),
					'id' => 'search_button',
					'name' => 'search_button',
					'element_name' => 'search_button',
					// 'disabled' => false,
					'class' => 'search_button',
					'onclick' => 'newLocation.showProduct()'
				))
		);

		$this->setChild('filter_button',
			$this->getLayout()->createBlock('adminhtml/widget_button')
				->setData(array(
					'label' => Mage::helper('customer')->__('Filter it'),
					'id' => 'filter_button',
					'name' => 'filter_button',
					'element_name' => 'filter_button',
					// 'disabled' => false,
					'class' => 'filter_button',
					'onclick' => 'newLocation.showAvailableLocation()'
				))
		);

		$this->setChild('print1_button',
			$this->getLayout()->createBlock('adminhtml/widget_button')
				->setData(array(
					'label' => Mage::helper('customer')->__('Print 1'),
					'id' => 'print1_button',
					'name' => 'print1_button',
					'element_name' => 'print1_button',
					// 'disabled' => false,
					'class' => 'print',
					'onclick' => 'newLocation.printLabels(1)'
				))
		);

		$this->setChild('print2_button',
			$this->getLayout()->createBlock('adminhtml/widget_button')
				->setData(array(
					'label' => Mage::helper('customer')->__('Print 2'),
					'id' => 'print2_button',
					'name' => 'print2_button',
					'element_name' => 'print2_button',
					// 'disabled' => false,
					'class' => 'print',
					'onclick' => 'newLocation.printLabels(2)'
				))
		);

        parent::_prepareLayout();
    }


	public function getUrlControllerAdmin()	{
    	$url = $this->getUrl('swstocklocation_admin/adminhtml_newlocation/ajax'/*, array('ajax'=>1)*/);
		return $url;
	}

}

