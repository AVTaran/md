<?php


class Sw_StockLocation_IndexController extends Mage_Core_Controller_Front_Action {


	public function indexAction() {
		$this->loadLayout();
		$this->renderLayout();
	}


	public function zonesAction() {
		$this->loadLayout();
		$this->renderLayout();
	}


	public function viewAction() {
		$zonesId = Mage::app()->getRequest()->getParam('id', 0);
		$zones = Mage::getModel('swstocklocation/zones')->load($zonesId);
		if ($zones->getId() > 0) {
			$this->loadLayout();
			$this->getLayout()->getBlock('zones.content')->assign(
				array(
					"zonesItem" => $zones,
				) 
			);
			$this->renderLayout();
		} else {
			$this->_forward('noRoute');
		}
	}





	public function blocksAction() {
		$this->loadLayout();
		$this->renderLayout();
	}

	public function viewblockAction() {
		$zonesId = Mage::app()->getRequest()->getParam('id', 0);
		$blocks = Mage::getModel('swstocklocation/blocks')->load($zonesId);
		if ($blocks->getId() > 0) {
			$this->loadLayout();
			$this->getLayout()->getBlock('blocks.content')->assign(
				array(
					"blocksItem" => $blocks,
				) 
			);
			$this->renderLayout();
		} else {
			$this->_forward('noRoute');
		}
	}

}


