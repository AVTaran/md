<?php


class sw_StockLocation_Block_Adminhtml_Boxes_Grid extends Mage_Adminhtml_Block_Widget_Grid {

	protected function _prepareCollection() {
		$collection = Mage::getModel('swstocklocation/boxes')->getCollection();
		$this->setCollection($collection);
		return parent::_prepareCollection();
	}


	protected function _prepareColumns() {
		$helper = Mage::helper('swstocklocation');
		$this->addColumn('id', array(
			'header' => $helper->__('Boxes ID'),
			'index' => 'id'
		));
		$this->addColumn('shelf', array(
			'header'	=> $helper->__('Shelf'),
			'index'		=> 'id_shelf',
			'options'	=> $helper->getObjectList('shelfs'),
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
		$this->addColumn('coordinates', array(
			'header' => $helper->__('coordinates'),
			'index' => 'coordinates',
			'type' => 'text',
		));
		$this->addColumn('dimensions', array(
			'header' => $helper->__('dimensions'),
			'index' => 'dimensions',
			'type' => 'text',
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


