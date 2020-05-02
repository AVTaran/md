<?php


class sw_StockLocation_Block_Adminhtml_Locations_Grid extends Mage_Adminhtml_Block_Widget_Grid {

	protected function _prepareCollection() {
		$collection = Mage::getModel('swstocklocation/locations')
			->getCollection()

			// ->addAttributeToSelect('*')
			// ->addAttributeToSelect('*', 'name')
		;

		$this->setCollection($collection);

		return parent::_prepareCollection();
	}

	protected function _prepareColumns() {
		$helper = Mage::helper('swstocklocation');
		$this->addColumn('id', array(
			'header'	=> $helper->__('Location ID'),
			'index'		=> 'id',
			'width'		=> '50px',
		));
		$this->addColumn('name', array(
			'header'	=> $helper->__('Location name'),
			// 'index'		=> 'Locationname',
			// 'type'		=> 'text',
			// 'width'		=> '100px',
			'renderer'	=> 'Sw_StockLocation_Block_Adminhtml_Locations_Grid_Renderer_Locationname',
			'filter'	=> false,
			// 'sort'		=> true,
		));

		$this->addColumn('zone', array(
			'header'	=> $helper->__('Zone'),
			'index'		=> 'id_zone',
			'options'	=> $helper->getObjectList('zones'),
			'type'		=> 'options',
			'width'		=> '50px',
		));
		$this->addColumn('block', array(
			'header'	=> $helper->__('Block'),
			'index'		=> 'id_block',
			'options'	=> $helper->getObjectList('blocks'),
			'type'		=> 'options',
			'width'		=> '50px',
		));
		$this->addColumn('shelf', array(
			'header'	=> $helper->__('Shelf'),
			'index'		=> 'id_shelf',
			'options'	=> $helper->getObjectList('shelfs'),
			'type'		=> 'options',
			'width'		=> '50px',
		));
		$this->addColumn('box', array(
			'header'	=> $helper->__('Box'),
			'index'		=> 'id_box',
			'options'	=> $helper->getObjectList('boxes'),
			'type'		=> 'options',
			'width'		=> '50px',
		));
		$this->addColumn('section', array(
			'header'	=> $helper->__('Section'),
			'index'		=> 'id_section',
			'options'	=> $helper->getObjectList('sections'),
			'type'		=> 'options',
			'width'		=> '50px',
		));

		/*
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


		//$this->addColumn('coordinates', array(
			//'header' => $helper->__('coordinates'),
			//'index' => 'coordinates',
			//'type' => 'text',
		//));
		//$this->addColumn('dimensions', array(
			//'header' => $helper->__('dimensions'),
			//'index' => 'dimensions',
			//'type' => 'text',
		//));
		*/

		return parent::_prepareColumns();
	}


	protected function _prepareMassaction() {
		$this->setMassactionIdField('id');
		$this->getMassactionBlock()->setFormFieldName('locations');
		$this->getMassactionBlock()->addItem('delete', array(
			'label' => $this->__('Delete'),
			'url' => $this->getUrl('*/*/massDelete'),
		));
		return $this;
	}


	public function getRowUrl($model) {
		return $this->getUrl('*/adminhtml_locations/edit', array(
			'id' => $model->getId(),
		));
	}

}


