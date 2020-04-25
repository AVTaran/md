<?php


class sw_StockLocation_Block_Adminhtml_Sizelocation_Grid extends Mage_Adminhtml_Block_Widget_Grid {

	protected function _prepareCollection() {

		$collection = Mage::getModel('swstocklocation/sizelocation')->getCollection();
		$this->setCollection($collection);
		return parent::_prepareCollection();
	}


	protected function _prepareColumns() {
		$helper = Mage::helper('swstocklocation');
		$this->addColumn('id', array(
			'header'	=> $helper->__('Type of box ID'),
			'index'		=> 'id',
			'width'		=> '50px',
		));
		$this->addColumn('name', array(
			'header'	=> $helper->__('Name'),
			'index'		=> 'name',
			'type'		=> 'text',
			'width'		=> '100px',
			// 'filter'	=> true,
			// 'sort'		=> true,
		));
		$this->addColumn('volume', array(
			'header'	=> $helper->__('Volume'),
			'index'		=> 'volume',
			'type'		=> 'text',
			'width'		=> '100px',
		));
		$this->addColumn('description', array(
			'header' => $helper->__('Description'),
			'index' => 'description',
			'type' => 'text',
		));
		return parent::_prepareColumns();
	}


	protected function _prepareMassaction() {
		$this->setMassactionIdField('id');
		$this->getMassactionBlock()->setFormFieldName('sizelocation');
		$this->getMassactionBlock()->addItem('delete', array(
			'label' => $this->__('Delete'),
			'url' => $this->getUrl('*/*/massDelete'),
		));
		return $this;
	}


	public function getRowUrl($model) {
		return $this->getUrl('*/adminhtml_sizelocation/edit', array(
			'id' => $model->getId(),
		));
	}

}


