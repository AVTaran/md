<?php


class sw_StockLocation_Block_Adminhtml_Stocklocation extends Mage_Adminhtml_Block_Template {

    public function __construct() {
        parent::__construct();
        $this->setTemplate('swstocklocation/index.phtml');
    }


    protected function _prepareLayout() {
        // $this->setChild('lastOrders',
        //       $this->getLayout()->createBlock('adminhtml/dashboard_orders_grid')
        // );

        $this->setChild('totals',
            $this->getLayout()->createBlock('adminhtml/dashboard_totals')
        );

        $this->setChild('sales',
            $this->getLayout()->createBlock('adminhtml/dashboard_sales')
        );

        $this->setChild('lastSearches',
            $this->getLayout()->createBlock('adminhtml/dashboard_searches_last')
        );

        $this->setChild('topSearches',
            $this->getLayout()->createBlock('adminhtml/dashboard_searches_top')
        );

        parent::_prepareLayout();
    }


}

