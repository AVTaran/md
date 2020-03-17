<?php


class Sw_StockLocation_StockLocationController extends Mage_Adminhtml_Controller_Action {

	public function indexAction() {
		$this->loadLayout();
		$this->renderLayout();
	}


	public function blocksAction() {

		$this->loadLayout();
		print_r('blocks');
		$this->renderLayout();
	}


	public function shelfsAction() {

		$this->loadLayout();
		print_r('shelfs');
		$this->renderLayout();
	}

	public function boxsAction() {

		$this->loadLayout();
		print_r('boxs');
		$this->renderLayout();
	}

	public function sectionsAction() {

		$this->loadLayout();
		print_r('section');
		$this->renderLayout();
	}

}

