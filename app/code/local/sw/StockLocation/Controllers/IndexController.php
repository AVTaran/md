<?php


class Sw_StockLocation_IndexController extends Mage_Core_Controller_Front_Action {

	//public function indexAction() {

		////echo "Hello. This is a StockLocation module";

		////$this->loadLayout();
		////$this->renderLayout();

		////$layoutHandles = $this->getLayout()->getUpdate()->getHandles();
		////echo '<pre>' . print_r($layoutHandles, true) . '</pre>';


		//$resource = Mage::getSingleton('core/resource');
		//$read = $resource->getConnection('core_read');
		//$table = $resource->getTableName('swstocklocation/table_zone');

		//$select = $read->select()
				//->from(
					//$table, 
					//array('id', 'name', 'coordinates', 'dimensions')
				//)
				//->order('name DESC');

		//$zones = $read->fetchAll($select);
		//// print_r($zones);

		//Mage::register('zones', $zones);

		//$this->loadLayout();
		//$this->renderLayout();
	//}

	/*
	public function indexAction() {

		$zones = Mage::getModel('swstocklocation/zones')->getCollection()->setOrder('id', 'DESC');

		$viewUrl = Mage::getUrl('stocklocation/index/view');

		echo '<h1>zones</h1>';
		foreach ($zones as $item) {
			echo '<h2>'.$item->getId().'. <a href="'.$viewUrl.'?id='.$item->getId().'">'.$item->getName().'</a></h2>';
		}
	}

	public function viewAction() {

		$ZoneId = Mage::app()->getRequest()->getParam('id', 0);
		$zone = Mage::getModel('swstocklocation/zones')->load($ZoneId);

		if ($zone->getId() > 0) {
			echo '<h1>' . $zone->getName() . '</h1>';
			echo '<div class="content">' . $zone->getCoordinates() . '</div>';
			echo '<div class="content">' . $zone->getDimensions() . '</div>';
		} else {
			$this->_forward('noRoute');
		}
	}
	*/



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


