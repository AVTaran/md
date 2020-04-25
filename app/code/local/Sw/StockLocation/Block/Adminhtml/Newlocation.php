<?php


class Sw_StockLocation_Block_Adminhtml_Newlocation extends Mage_Adminhtml_Block_Abstract // Mage_Adminhtml_Block_Template
{

    public function __construct() {
        parent::__construct();

        $this->setTemplate('swstocklocation/newlocation.phtml');
		// $this->_addButtonLabel = Mage::helper('swstocklocation')->__('Add New button');
		$data = Mage::registry('data');
	}


    protected function _prepareLayout() {

        $this->setChild('filter',
            $this->getLayout()->createBlock('swstocklocation/adminhtml_newlocation_filter')
		);

		$this->setChild('print1_button',
			$this->getLayout()->createBlock('adminhtml/widget_button')
				->setData(array(
					'label'  => Mage::helper('customer')->__('Print 1'),
					'id'     => 'print1_button',
					'name'   => 'print1_button',
					'element_name' => 'print1_button',
					// 'disabled' => false,
					'class'  => 'print',
					'onclick'=> 'newLocationModel.printLabels()'
				))
		);


        parent::_prepareLayout();
    }

	/*
	public function ajaxBlockAction()
	{
		$output   = '';
		$blockTab = $this->getRequest()->getParam('block');
		if (in_array($blockTab, array('tab_orders', 'tab_amounts', 'totals'))) {
			$output = $this->getLayout()->createBlock('adminhtml/dashboard_' . $blockTab)->toHtml();
		}
		$this->getResponse()->setBody($output);
		return;
	}
	*/

}

