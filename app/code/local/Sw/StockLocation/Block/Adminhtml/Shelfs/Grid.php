<?php


class sw_StockLocation_Block_Adminhtml_Shelfs_Grid extends Mage_Adminhtml_Block_Widget_Grid {

	public function __construct() {
		parent::__construct();
		// $this->setId('sales_order_grid');
		// $this->setUseAjax(true);
		// $this->setDefaultSort('created_at');
		// $this->setDefaultDir('DESC');
		$this->setSaveParametersInSession(true);
	}

	protected function _prepareCollection() {
		$collection = Mage::getModel('swstocklocation/shelfs')->getCollection();

		$tableBl = Mage::getSingleton('core/resource')->getTableName('swstocklocation/table_block');
		$collection->getSelect()->joinLeft(
			$tableBl,
			'`main_table`.`id_block` = `'.$tableBl.'`.`id`',
			array('id_zone')
		);

		$this->setCollection($collection);
		return parent::_prepareCollection();
	}

	protected function _addColumnFilterToCollection($column) {
		$filterArr = Mage::registry('preparedFilter');

		if ( ($column->getId() === 'store_id' || $column->getId() === 'status')
			  &&
				$column->getFilter()->getValue()
			  &&
				strpos($column->getFilter()->getValue(), ',')
		) {

			$_inNin = explode(',', $column->getFilter()->getValue());
			$inNin = array();

			foreach ($_inNin as $k => $v) {
				if (is_string($v) && strlen(trim($v))) {
					$inNin[] = trim($v);
				}
			}

			if (count($inNin)>1 && in_array($inNin[0], array('in', 'nin'))) {
				$in = $inNin[0];
				$values = array_slice($inNin, 1);
				$this->getCollection()->addFieldToFilter($column->getId(), array($in => $values));
			} else {
				parent::_addColumnFilterToCollection($column);

			}

		} elseif (is_array($filterArr) && array_key_exists($column->getId(), $filterArr) && isset($filterArr[$column->getId()])) {
			$this->getCollection()->addFieldToFilter($column->getId(), $filterArr[$column->getId()]);

		} else {
			parent::_addColumnFilterToCollection($column);

		}

		// Zend_Debug::dump((string)$column->getId(), '$column->getId(): ');
		// Zend_Debug::dump((string)$this->getCollection()->getSelect(), 'Prepared filter: ');

		return $this;
	}


	protected function _prepareColumns() {
		$helper = Mage::helper('swstocklocation');

		$filterForObjList = $helper->getFilterForObjList($this->getRequest()->getParam('filter'));

		$this->addColumn('id', array(
			'header' 		=> $helper->__('Shelfs ID'),
			'index' 		=> 'id',
			'width'			=> '50px',
		));
		$this->addColumn('zones', array(
			'header'		=> $helper->__('Zone'),
			'index'			=> 'id_zone',
			'options'		=> $helper->getObjectList('zones'),
			'type'			=> 'options',
			'width'			=> '80px',
			// 'filter_condition_callback' => array($this, '_zoneFilter'),
		));
		$this->addColumn('blocks', array(
			'header'		=> $helper->__('Block'),
			'index'			=> 'id_block',
			'options'		=> $helper->getObjectList('blocks', $filterForObjList),
			'type'			=> 'options',
			'width'			=> '80px',
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

	protected function _zoneFilter($collection, $column) {
		if (!$value = $column->getFilter()->getValue()) {

			return $this;
		}

		// echo $this->getCollection()->getSelect();
		//		$this->getCollection()->getSelect()->where(
		//			"sales_flat_order_address.city like ?
		//            OR sales_flat_order_address.street like ?
		//            OR sales_flat_order_address.postcode like ?"
		//			,
		//			"%$value%"
		//		);


		return $this;
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


