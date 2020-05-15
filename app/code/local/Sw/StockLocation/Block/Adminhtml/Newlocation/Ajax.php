<?php


class Sw_StockLocation_Block_Adminhtml_Newlocation_Ajax extends  Mage_Adminhtml_Block_Abstract //
	// Mage_Core_Block_Template //
	// Mage_Adminhtml_Block_Dashboard_Bar
{
    protected function _construct()
    {
        parent::_construct();
		$this->setTemplate('swstocklocation/newlocation_ajax.phtml');
    }

	public function getAjaxContent() {
		$params = $this->getRequest()->getParams();

		switch ($params['operation']) {
			case 'getAvailableLocation':
				$content = $this->getAjaxAvailableLocation($params['param']);
				break;
			case 'getProduct':
				$content = $this->getAjaxProduct($params['param']);
				break;
			case 'updateQtyLocationProduct':
				$content = $this->ajaxUpdateQtyLocationProduct($params['param']);
				break;
			default:
				$content = $this->getAjaxDefault();
			break;
		}

		$content = json_encode($content, 0, 512);
		return $content;
	}

	public function getAjaxAvailableLocation($params) {
		$ret = array();
		$helper = Mage::helper('swstocklocation');

		$resource = Mage::getSingleton('core/resource');
		$connection = $resource->getConnection('core_write');

		$tableLp = $resource->getTableName('swstocklocation/table_location_product');
		$tableL  = $resource->getTableName('swstocklocation/table_location');
		$tableZ  = $resource->getTableName('swstocklocation/table_zone');
		$tableBl = $resource->getTableName('swstocklocation/table_block');
		$tableSh = $resource->getTableName('swstocklocation/table_shelf');
		$tableBo = $resource->getTableName('swstocklocation/table_box');
		$tableSe = $resource->getTableName('swstocklocation/table_section');

		$select = $connection->select()
			->from(['l' => $tableL], ['l.id, getVolumeLocation(l.id) AS volumeLocation'])
			->from(['z' => $tableZ], ['z.name AS zone'])
			->joinLeft(['bl' => $tableBl], 'l.id_block=bl.id', ['bl.name AS block'])
			->joinLeft(['sh' => $tableSh], 'l.id_shelf=sh.id', ['sh.name AS shelf'])
			->joinLeft(['box' => $tableBo], 'l.id_box=box.id', ['box.name AS box'])
			->joinLeft(['se' => $tableSe], 'l.id_section=se.id', ['se.name AS section'])
			->joinLeft(['lp' => $tableLp], 'l.id=lp.id_location')
			->where('l.id_zone=z.id')
			->where('lp.id_product IS NULL')
			->limit($params['limit'])
		;

		// print_r($params);
		if (!in_array('Any', $params['filter']['zone']) AND count($params['filter']['zone'])>0) {
			$select->where(
				'l.id_zone IN ('. implode(',',$params['filter']['zone']).')'
			);
		}
		if (!in_array('Any', $params['filter']['type']) AND count($params['filter']['type'])>0) {
			$select->where(
				'box.id_typebox IN ('. implode(',',$params['filter']['type']).')'
			);
		}
		if (!in_array('Any', $params['filter']['size']) AND count($params['filter']['size'])>0) {

			$listSize = implode(',',$params['filter']['size']);
			$tableLS = $resource->getTableName('swstocklocation/table_locsize');
			$selectMin = $connection->select()
				->from(['ls' => $tableLS], ['MIN(ls.volumeMin) AS volumeMin'])
				->where('ls.id IN ('.$listSize.')')
			;
			$volumeMin = $connection->fetchOne($selectMin);
			// $volumeMin = $volumeMin['volumeMin'];

			$selectMax = $connection->select()
				->from(['ls' => $tableLS], ['MAX(ls.volumeMax) AS volumeMax'])
				->where('ls.id IN ('.$listSize.')')
			;
			// echo $selectMax."\n\n\n";
			$volumeMax = $connection->fetchOne($selectMax);

			// $volumeMax = $volumeMax['volumeMax'];
			// print_r($volumeMax);

			$select->where ('getVolumeLocation(l.id) BETWEEN ('.$volumeMin.') AND ('.$volumeMax.')');
		}

		// echo $select;

		$arLocation = $connection->fetchAll($select);

		$locationsTable = '
			<h3>We have not locations which match filter\'s criteria. :-(</h3> 
			<p>Please, try to change the filter.</p>
		';
		if (count($arLocation)>0) {
			$locationsTable ='
				<h3>'.count($arLocation).' available locations:</h3>
				<table id="tableLinksLocationProduction">
					<thead>
						<tr>
							<td>Location</td>
							<td>Dimension</td>
							<td>Volume. liters'."\t\t\t".'(sm<sup>3</sup>)</td>
						</tr>					
					</thead>
					<tbody>
			';
			foreach ($arLocation AS $key => $location) {
				$locationsTable .='
						<tr>
							<td>
								<a locationId="'.$location['id'].'" 
									onclick="newLocation.updateTableLinksLocationProduct(this);"
								>
									'.$helper->getLocationName($location['id']).'
								</a>
							</td>
							<td></td>
							<td>
								'.round($location['volumeLocation']/1000,2)."\t\t\t".
								'<small>('.$location['volumeLocation'].')</small>
							</td>
						</tr>	
				';
			}
			$locationsTable .='
					</tbody>
				</table>
			';
		}

		/*
		SELECT
			CONCAT(`z`.`name`, `bl`.`name`,'-',`sh`.`name`,'/', `box`.`name`, `se`.`name`) `locationName`,
			`z`.`name` `zone`,
			`bl`.`name` `block`,
			`sh`.`name` `shelf`,
			`box`.`name` `box`,
			`se`.`name` `section`
		FROM
			`sw_sl_location` `l`
				LEFT JOIN `sw_sl_block` `bl` ON `l`.`id_block`=`bl`.`id`
				LEFT JOIN `sw_sl_shelf` `sh` ON `l`.`id_shelf`=`sh`.`id`
				LEFT JOIN `sw_sl_box` `box` ON `l`.`id_box`=`box`.`id`
				LEFT JOIN `sw_sl_section` `se` ON `l`.`id_section`=`se`.`id`,
			`sw_sl_zone` `z`
		WHERE
			`l`.`id_zone`=`z`.`id`
		LIMIT
			10
		;
		*/

		$ret['arLocation'] = $arLocation;
		$ret['locationsTable'] = $locationsTable;

		return $ret;
	}

	public function getAjaxProduct($params) {
		$ret = array();

		$productInformation = null;

		if (!isset($params['prodId']) OR $params['prodId']==0) {
			$queryName = $params['searchLine'];

			$productModel = Mage::getModel('catalog/product')
				->getCollection()
				->addAttributeToSelect('name', 'entity_id', 'price')
				->addAttributeToFilter(
					'sku',
					array (
						'like' => '%'.$queryName.'%'
					)
				)
				// ->addAttributeToFilter('name', array('like' => '%'.$queryName.'%'))
				->getFirstItem()
			;
			$productId = $productModel->getID();
		} else {
			$productId = $params['prodId'];
		}


		if ($productId) {
			$product = Mage::getModel('catalog/product')->load($productId);

			$productInformation = $this->getLayout()
				->createBlock('swstocklocation/adminhtml_newlocation_ajaxproductinfo')
				->setProduct($product)
				// ->setHelper($helper)
				->toHtml()
			;
		}

		/*
		$sAttributeName = 'size';
		$mOptionValue = 'medium';
		$collection = Mage::getModel('catalog/product')->getCollection()
			->addAttributeToSelect('*')
			->addFieldToFilter(
				$sAttributeName,
				array (
					'eq' => Mage::getResourceModel('catalog/product')
						->getAttribute($sAttributeName)
						->getSource()
						->getOptionId($mOptionValue)
				)
			);
		*/


		$ret['productInformation'] = $productInformation;
		//$ret['product'] = $product;
		return $ret;
	}

	public function ajaxUpdateQtyLocationProduct($params) {
		$ret = array();
		if (($params['prodId'] + $params['locId'] + $params['Qty'])<3) {
			$ret['error'][] = 'Not correct parameters: '.$params['prodId'].'; '.$params['locId'].'; '.$params['Qty'].'.';
			return $ret;
		}

		$lp = Mage::getModel('swstocklocation/locationproduct')->getCollection()
			->addFieldToFilter('id_product', array('eq' => $params['prodId']))
			->addFieldToFilter('id_location', array('eq' => $params['locId']))
			->load()
			->toArray()
		;

		// print_r($lp);

		if ($lp['totalRecords']>1) {
			$ret['error'][] = 'Something wrong. More than one record in the table location_product. IDs: '.$params['prodId'].'; '.$params['locId'].'.';
			return $ret;
		} elseif ($lp['totalRecords']==0) {
			try {
				$resource = Mage::getSingleton('core/resource');
				$table = $resource->getTableName('swstocklocation/table_location_product');
				$writeConnection = Mage::getSingleton('core/resource')->getConnection('core_write');
				$sql = '
					INSERT INTO '.$table. ' (`id_product`, `id_location`, `qty`)
					VALUES ('.(int)$params['prodId'].', '.(int)$params['locId'].', '.(int)$params['Qty'].' ) 
				';
				$writeConnection->query( $sql );

				$ret['id_location'] = $params['locId'];
				$ret['id_product']  = $params['prodId'];
			} catch (Exception $e) {
				$ret['error'][] = $e->getMessage();
			}

		} elseif ($lp['totalRecords']==1) {

			$qty = $lp['items'][0]['qty'] + $params['Qty'];
			if ($qty>=0) {
				$resource = Mage::getSingleton('core/resource');
				$table = $resource->getTableName('swstocklocation/table_location_product');
				$writeConnection = Mage::getSingleton('core/resource')->getConnection('core_write');
				$writeConnection->update(
					$table,
					array( 'qty' => $qty ),
					'id_product='.$params['prodId'].' AND id_location='.$params['locId']
				);

				$ret['id_location'] = $lp['items'][0]['id_location'];
				$ret['id_product']  = $lp['items'][0]['id_product'];
			} else {
				//  TODO if qty after operation will be less than 0 - constrain
				$ret['error'][] = 'Qty is less than 0. Are you sure?';
			}
		}

		if (count($ret['error'])==0) {
			$ret = $this->getAjaxProduct($params);
		}

		return $ret;
	}

	public function getAjaxDefault () {
    	return 'unknown request';
	}


}
