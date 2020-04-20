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
			'index' => 'id',
			'width'		=> '50px',
		));
		$this->addColumn('block', array(
			'header'	=> $helper->__('Block'),
			'index'		=> 'id_block',
			'options'	=> $helper->getObjectList('blocks'),
			'type'		=> 'options',
			'width'		=> '100px',
		));
		$this->addColumn('Name', array(
			'header' => $helper->__('Name'),
			'index' => 'name',
			'type' => 'text',
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

//		$this->addColumn('coordinates', array(
//			'header' => $helper->__('coordinates'),
//			'index' => 'coordinates',
//			'type' => 'text',
//		));
//		$this->addColumn('dimensions', array(
//			'header' => $helper->__('dimensions'),
//			'index' => 'dimensions',
//			'type' => 'text',
//		));
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


