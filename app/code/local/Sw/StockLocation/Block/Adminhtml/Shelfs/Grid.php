<?php


class sw_StockLocation_Block_Adminhtml_Shelfs_Grid extends Mage_Adminhtml_Block_Widget_Grid {

	protected function _prepareCollection() {
		$collection = Mage::getModel('swstocklocation/shelfs')->getCollection();
		$this->setCollection($collection);
		return parent::_prepareCollection();
	}


	protected function _prepareColumns() {
		$helper = Mage::helper('swstocklocation');
		$this->addColumn('id', array(
			'header' => $helper->__('Shelfs ID'),
			'index' => 'id'
		));
		$this->addColumn('Name', array(
			'header' => $helper->__('Name'),
			'index' => 'name',
			'type' => 'text',
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
		$this->getMassactionBlock()->setFormFieldName('shelfs');
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
			'*/adminhtml_shelfs/edit', 
			array(
				'id' => $model->getId(),
			)
		);
	}

}


