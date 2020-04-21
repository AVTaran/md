<?php


class sw_StockLocation_Block_Adminhtml_Newlocation extends Mage_Adminhtml_Block_Template {

    public function __construct() {
        parent::__construct();
        $this->setTemplate('swstocklocation/newlocation.phtml');
    }


    protected function _prepareLayout() {

        $this->setChild('filter',
            $this->getLayout()->createBlock('swstocklocation/adminhtml_newlocation_filter')
        );


        parent::_prepareLayout();
    }

/*	public function ajaxBlockAction()
	{
		$output   = '';
		$blockTab = $this->getRequest()->getParam('block');
		if (in_array($blockTab, array('tab_orders', 'tab_amounts', 'totals'))) {
			$output = $this->getLayout()->createBlock('adminhtml/dashboard_' . $blockTab)->toHtml();
		}
		$this->getResponse()->setBody($output);
		return;
	}*/

}

