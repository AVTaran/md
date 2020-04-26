<?php


class Sw_StockLocation_Block_Adminhtml_Newlocation extends Mage_Adminhtml_Block_Abstract // Mage_Adminhtml_Block_Template
{

    public function __construct() {
        parent::__construct();

        // $this->setTemplate('swstocklocation/newlocation.phtml');
		// $this->_addButtonLabel = Mage::helper('swstocklocation')->__('Add New button');

		if ($this->getRequest()->getParam('isAjax') OR $this->getRequest()->getParam('ajax')) {
			$this->setTemplate('swstocklocation/newlocation_ajax.phtml');
		} else {
			$this->setTemplate('swstocklocation/newlocation.phtml');
		}

	}


    protected function _prepareLayout() {

		if ($this->getRequest()->getParam('isAjax') OR $this->getRequest()->getParam('ajax')) {

		} else {
			$this->setChild('filter',
				$this->getLayout()->createBlock('swstocklocation/adminhtml_newlocation_filter')
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
						'onclick' => 'newLocationModel.printLabels(1)'
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
						'onclick' => 'newLocationModel.printLabels(2)'
					))
			);

		}

        parent::_prepareLayout();
    }


	public function getUrlControllerAdmin()	{
    	$url = $this->getUrl('swstocklocation_admin/adminhtml_newlocation/ajax'/*, array('ajax'=>1)*/);
		return $url;
	}


}

