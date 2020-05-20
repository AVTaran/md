<?php


class sw_StockLocation_Block_Adminhtml_Blocks_Grid extends Mage_Adminhtml_Block_Widget_Grid {

	protected function _prepareCollection() {

		$collection = Mage::getModel('swstocklocation/blocks')->getCollection();
		$this->setCollection($collection);
		return parent::_prepareCollection();
	}


	protected function _prepareColumns() {
		$helper = Mage::helper('swstocklocation');
		$this->addColumn('id', array(
			'header'		=> $helper->__('Block ID'),
			'index'			=> 'id',
			'width'			=> '50px',
		));
		$this->addColumn('zone', array(
			'header'		=> $helper->__('Zone'),
			'index'			=> 'id_zone',
			'options'		=> $helper->getObjectList('zones'),
			'type'			=> 'options',
			'width'			=> '50px',
		));
		$this->addColumn('name', array(
			'header'		=> $helper->__('Name'),
			'index'			=> 'name',
			'filter_index'  => 'main_table.name',
			'type'			=> 'text',
			// 'filter'	=> true,
			// 'sort'		=> true,
		));

		$this->addColumn('length', array(
			'header'		=> $helper->__('Length'),
			'index'			=> 'length',
			'filter_index'  => 'main_table.length',
			'type'			=> 'text',
			'width'			=> '50px',
		));
		$this->addColumn('width', array(
			'header'		=> $helper->__('width'),
			'index'			=> 'width',
			'filter_index'  => 'main_table.width',
			'type'			=> 'text',
			'width'			=> '50px',
		));
		$this->addColumn('height', array(
			'header'		=> $helper->__('height'),
			'index'			=> 'height',
			'filter_index'  => 'main_table.height',
			'type'			=> 'text',
			'width'			=> '50px',
		));

		$this->addColumn('sp_x', array(
			'header'		=> $helper->__('sp_x'),
			'index'			=> 'sp_x',
			'filter_index'  => 'main_table.sp_x',
			'type'			=> 'text',
			'width'			=> '50px',
		));
		$this->addColumn('sp_y', array(
			'header'		=> $helper->__('sp_y'),
			'index'			=> 'sp_y',
			'filter_index'  => 'main_table.sp_y',
			'type'			=> 'text',
			'width'			=> '50px',
		));
		$this->addColumn('sp_z', array(
			'header'		=> $helper->__('sp_z'),
			'index'			=> 'sp_z',
			'filter_index'  => 'main_table.sp_z',
			'type'			=> 'text',
			'width'			=> '50px',
		));

		$this->addColumn('approx_length', array(
			'header'		=> $helper->__('A. Length'),
			'index'			=> 'approx_length',
			'filter_index'  => 'main_table.length',
			'type'			=> 'text',
			'width'			=> '50px',
		));
		$this->addColumn('approx_width', array(
			'header'		=> $helper->__('A. width'),
			'index'			=> 'approx_width',
			'filter_index'  => 'main_table.width',
			'type'			=> 'text',
			'width'			=> '50px',
		));
		$this->addColumn('approx_height', array(
			'header'		=> $helper->__('A. height'),
			'index'			=> 'approx_height',
			'filter_index'  => 'main_table.height',
			'type'			=> 'text',
			'width'			=> '50px',
		));

		return parent::_prepareColumns();
	}


	protected function _prepareMassaction() {
		$this->setMassactionIdField('id');
		$this->getMassactionBlock()->setFormFieldName('blocks');
		$this->getMassactionBlock()->addItem('delete', array(
			'label' => $this->__('Delete'),
			'url' => $this->getUrl('*/*/massDelete'),
		));
		return $this;
	}


	public function getRowUrl($model) {
		return $this->getUrl('*/adminhtml_blocks/edit', array(
			'id' => $model->getId(),
		));
	}

}


