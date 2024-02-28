<?php


class sw_StockLocation_Block_Adminhtml_Locations_Grid extends Mage_Adminhtml_Block_Widget_Grid {

	protected function _prepareCollection() {
		$collection = Mage::getModel('swstocklocation/locations')
			->getCollection()
			// ->addAttributeToSelect('*')
			// ->addAttributeToSelect('name')
		;

		//join with product
		$tableLp = Mage::getSingleton('core/resource')->getTableName('swstocklocation/table_location_product');
		$collection->getSelect()->joinLeft(
			$tableLp,					// array('table_alias' => 'some_long_table_name'),
			'`main_table`.`id`=`'.$tableLp .'`.`id_location`',
			array('qty' => 'qty')
		);

		$entityProduct = Mage::getSingleton("core/resource")->getTableName('catalog_product_entity');
		$collection->getSelect()->joinLeft(
			$entityProduct,
			'`'.$tableLp .'`.`id_product` = `'.$entityProduct.'`.`entity_id`',
			array('sku' => 'sku')
		);

		$productAttributes = array('name', 'price', 'url_key');
		foreach ($productAttributes as $attributeCode) {
			$alias     = $attributeCode . '_table';
			$attribute = Mage::getSingleton('eav/config')
				->getAttribute(Mage_Catalog_Model_Product::ENTITY, $attributeCode);

			/** Adding eav attribute value */
			$collection->getSelect()->joinLeft(
				array($alias => $attribute->getBackendTable()),
				$tableLp.".id_product = $alias.entity_id AND $alias.attribute_id={$attribute->getId()}",
				array($alias.'_'.$attributeCode.'' => 'value')
			);
		}

		// echo $collection->getSelect();

		$this->setCollection($collection);
		return parent::_prepareCollection();
	}

	protected function _prepareColumns() {
		$helper = Mage::helper('swstocklocation');
		$filterForObjList = $helper->getFilterForObjList($this->getRequest()->getParam('filter'));
		//		echo '<pre>';
		//		print_r($filterForObjList);
		//		echo '</pre>';

		$this->addColumn('id', array(
			'header'	=> $helper->__('Location ID'),
			'index'		=> 'id',
			'width'		=> '50px',
		));

		$this->addColumn('zones', array(
			'header'	=> $helper->__('Zone'),
			'index'		=> 'id_zone',
			'options'	=> $helper->getObjectList('zones'),
			'type'		=> 'options',
			'width'		=> '50px',
		));
		$this->addColumn('blocks', array(
			'header'	=> $helper->__('Block'),
			'index'		=> 'id_block',
			'options'	=> $helper->getObjectList('blocks', $filterForObjList),
			'type'		=> 'options',
			'width'		=> '50px',
		));
		$this->addColumn('shelfs', array(
			'header'	=> $helper->__('Shelf'),
			'index'		=> 'id_shelf',
			'options'	=> $helper->getObjectList('shelfs', $filterForObjList),
			'type'		=> 'options',
			'width'		=> '50px',
		));
		$this->addColumn('boxes', array(
			'header'	=> $helper->__('Box'),
			'index'		=> 'id_box',
			'options'	=> $helper->getObjectList('boxes', $filterForObjList),
			'type'		=> 'options',
			'width'		=> '50px',
		));
		$this->addColumn('sections', array(
			'header'	=> $helper->__('Section'),
			'index'		=> 'id_section',
			'options'	=> $helper->getObjectList('sections', $filterForObjList),
			'type'		=> 'options',
			'width'		=> '50px',
		));

		$this->addColumn('name', array(
			'header'	=> $helper->__('Location name'),
			// 'index'		=> 'Locationname',
			// 'type'		=> 'text',
			'width'		=> '100px',
			'renderer'	=> 'Sw_StockLocation_Block_Adminhtml_Locations_Grid_Renderer_Locationname',
			'filter'	=> false,
			// 'sort'		=> true,
		));

		$this->addColumn('dimensions', array(
			'header'	=> $helper->__('Location dimension'),
			// 'index'		=> 'Locationdimensions',
			// 'type'		=> 'text',
			'width'		=> '100px',
			'renderer'	=> 'Sw_StockLocation_Block_Adminhtml_Locations_Grid_Renderer_Locationdimensions',
			'filter'	=> false,
			// 'sort'		=> true,
		));

		$this->addColumn('name_table_name', array(
			'header'	=> $helper->__('Product'),
			'index'		=> 'name_table_name',
			'type'		=> 'text',
			// 'width'		=> '100px',
			// 'filter'	=> true,
			// 'sort'		=> true,
		));
		$this->addColumn('sku', array(
			'header'	=> $helper->__('Product sku'),
			'index'		=> 'sku',
			'type'		=> 'text',
			'width'		=> '100px',
			// 'filter'	=> true,
			// 'sort'		=> true,
		));
		$this->addColumn('qty', array(
			'header'	=> $helper->__('Quantity'),
			'index'		=> 'qty',
			'type'		=> 'text',
			'width'		=> '50px',
			// 'filter'	=> true,
			// 'sort'		=> true,
		));

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


