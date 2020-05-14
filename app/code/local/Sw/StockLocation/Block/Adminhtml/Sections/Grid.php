<?php


class sw_StockLocation_Block_Adminhtml_Sections_Grid extends Mage_Adminhtml_Block_Widget_Grid {

	protected function _prepareCollection() {
		$collection = Mage::getModel('swstocklocation/sections')->getCollection();

		$tableBo = Mage::getSingleton('core/resource')->getTableName('swstocklocation/table_box');
		$collection->getSelect()->joinLeft(
			$tableBo,
			'main_table.id_box = '.$tableBo.'.id',
			array('id_shelf')
		);

		$tableSh = Mage::getSingleton('core/resource')->getTableName('swstocklocation/table_shelf');
		$collection->getSelect()->joinLeft(
			$tableSh,
			$tableBo.'.id_shelf = '.$tableSh.'.id',
			array('id_block')
		);

		$tableBl = Mage::getSingleton('core/resource')->getTableName('swstocklocation/table_block');
		$collection->getSelect()->joinLeft(
			$tableBl,
			$tableSh.'.`id_block` = `'.$tableBl.'`.`id`',
			array('id_zone')
		);

		$this->setCollection($collection);
		return parent::_prepareCollection();
	}


	protected function _prepareColumns() {
		$helper = Mage::helper('swstocklocation');
		$filterForObjList = $helper->getFilterForObjList($this->getRequest()->getParam('filter'));

		$this->addColumn('id', array(
			'header' 		=> $helper->__('Sections ID'),
			'index' 		=> 'id',
			'width'			=> '40px',
		));

		$this->addColumn('zones', array(
			'header'		=> $helper->__('Zone'),
			'index'			=> 'id_zone',
			'options'		=> $helper->getObjectList('zones'),
			'type'			=> 'options',
			'width'			=> '50px',
			// 'filter_condition_callback' => array($this, '_zoneFilter'),
		));
		$this->addColumn('blocks', array(
			'header'		=> $helper->__('Block'),
			'index'			=> 'id_block',
			'options'		=> $helper->getObjectList('blocks', $filterForObjList),
			'type'			=> 'options',
			'width'			=> '50px',
		));
		$this->addColumn('shelfs', array(
			'header'		=> $helper->__('Shelf'),
			'index'			=> 'id_shelf',
			'options'		=> $helper->getObjectList('shelfs', $filterForObjList),
			'type'			=> 'options',
			'width'			=> '50px',
		));
		$this->addColumn('boxes', array(
			'header'		=> $helper->__('Box'),
			'index'			=> 'id_box',
			'options'		=> $helper->getObjectList('boxes', $filterForObjList),
			'type'			=> 'options',
			'width'			=> '50px',
		));

		$this->addColumn('Name', array(
			'header'		=> $helper->__('Name'),
			'index' 		=> 'name',
			'filter_index'  => 'main_table.name',
			'type' 			=> 'text',
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

		return parent::_prepareColumns();
	}


	protected function _prepareMassaction() {
		$this->setMassactionIdField('id');
		$this->getMassactionBlock()->setFormFieldName('sections');
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


