<?php


class sw_StockLocation_Block_Adminhtml_Boxes_Grid extends Mage_Adminhtml_Block_Widget_Grid {

	protected function _prepareCollection() {
		$collection = Mage::getModel('swstocklocation/boxes')->getCollection();
		$this->setCollection($collection);
		return parent::_prepareCollection();
	}


	protected function _prepareColumns() {
		
		$helper = Mage::helper('swstocklocation');
		$filterForObjList = $helper->getFilterForObjList($this->getRequest()->getParam('filter'));

		$this->addColumn('id', array(
			'header' 	=> $helper->__('Boxes ID'),
			'index' 	=> 'id',
			'width'		=> '40px',
		));

		$this->addColumn('zone', array(
			'header'	=> $helper->__('Zone'),
			'index'		=> 'id_zone',
			'options'	=> $helper->getObjectList('zones'),
			'type'		=> 'options',
			'width'		=> '80px',
			// 'filter_condition_callback' => array($this, '_zoneFilter'),
		));
		$this->addColumn('block', array(
			'header'	=> $helper->__('Block'),
			'index'		=> 'id_block',
			'options'	=> $helper->getObjectList('blocks', $filterForObjList['block']),
			'type'		=> 'options',
			'width'		=> '80px',
		));

		$this->addColumn('shelf', array(
			'header'	=> $helper->__('Shelf'),
			'index'		=> 'id_shelf',
			'options'	=> $helper->getObjectList('shelfs', $filterForObjList['shelfs']),
			'type'		=> 'options',
			'width'		=> '50px',
		));
		$this->addColumn('Name', array(
			'header' => $helper->__('Name'),
			'index' => 'name',
			'type' => 'text',
		));
		$this->addColumn('typeboxes', array(
			'header'	=> $helper->__('Type of box'),
			'index'		=> 'id_typebox',
			'options'	=> $helper->getObjectList('typeboxes'),
			'type'		=> 'options',
			'width'		=> '50px',
		));

		$this->addColumn('length', array(
			'header'	=> $helper->__('Length'),
			'index'		=> 'length',
			'type'		=> 'text',
			'width'		=> '50px',
		));
		$this->addColumn('width', array(
			'header'	=> $helper->__('width'),
			'index'		=> 'width',
			'type'		=> 'text',
			'width'		=> '50px',
		));
		$this->addColumn('height', array(
			'header'	=> $helper->__('height'),
			'index'		=> 'height',
			'type'		=> 'text',
			'width'		=> '50px',
		));

		$this->addColumn('sp_x', array(
			'header'	=> $helper->__('sp_x'),
			'index'		=> 'sp_x',
			'type'		=> 'text',
			'width'		=> '50px',
		));
		$this->addColumn('sp_y', array(
			'header'	=> $helper->__('sp_y'),
			'index'		=> 'sp_y',
			'type'		=> 'text',
			'width'		=> '50px',
		));
		$this->addColumn('sp_z', array(
			'header'	=> $helper->__('sp_z'),
			'index'		=> 'sp_z',
			'type'		=> 'text',
			'width'		=> '50px',
		));
		
		return parent::_prepareColumns();
	}


	protected function _prepareMassaction() {
		$this->setMassactionIdField('id');
		$this->getMassactionBlock()->setFormFieldName('boxes');
		$this->getMassactionBlock()->addItem(
			'delete', 
			array(
				'label' => $this->__('Delete'),
				'url' => $this->getUrl('*/*/massDelete'),
			)
		);
		return $this;
	}


	public function getRowUrl($model) {
		return $this->getUrl(
			'*/*/edit', 
			array(
				'id' => $model->getId(),
			)
		);
	}

}


