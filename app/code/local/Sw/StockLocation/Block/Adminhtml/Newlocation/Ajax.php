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
		$content = '';
		$params = $this->getRequest()->getParams();

		switch ($params['operation']) {
			case 'getAvailableLocation':
				$content = $this->getAjaxAvailableLocation($params['param']);
				break;
			default:
				$content = $this->getAjaxDefault();
			break;
		}


		//	$output   = '';
		//	$blockTab = $this->getRequest()->getParam('block');
		//
		//	if (in_array($blockTab, array('tab_orders', 'tab_amounts', 'totals'))) {
		//		$output = $this->getLayout()->createBlock('adminhtml/dashboard_' . $blockTab)->toHtml();
		//	}
		//
		//	$this->getResponse()->setBody($output);

		//	return;

		$content = json_encode($content, 0, 512);
		return $content;
	}

	public function getAjaxAvailableLocation($params) {
		$ret = array();

//		$arZones = array();
//		$collectionOfZones =  Mage::getModel('swstocklocation/zones')->getCollection()->load();
//
//		foreach($collectionOfZones AS $Obj) {
//			$arZones[$Obj->getId()] = array (
//				'name' => $Obj->getName(),
//				'volume' => $Obj->getVolume(),
//				'description' => $Obj->getDescription(),
//			);
//		}
		// return $arZones;


		$resource = Mage::getSingleton('core/resource');
		$write = $resource->getConnection('core_write');

		// $read= Mage::getSingleton('core/resource')->getConnection('core_read');

		// $connection = Mage::getSingleton('core/resource')->getConnection('core_read');
		// $connection->

		//		$collection -> getSelect() -> joinLeft(array("oauth"=>'customer_entity_varchar'),
		//			'main_table.customer_id=oauth.entity_id and oauth.attribute_id = 156',
		//			array('OauthProvider' => "value"));



		// $tableL  = $resource->getTableName('swstocklocation/locations');
		$tableL  = 'sw_sl_location';

		// $tableZ  = $resource->getTableName('swstocklocation/zones');
		$tableZ  = 'sw_sl_zone';

		// $tableBl = $resource->getTableName('swstocklocation/blocks');
		$tableBl = 'sw_sl_block';

		// $tableSh = $resource->getTableName('swstocklocation/shelfs');
		$tableSh = 'sw_sl_shelf';

		// $tableBo = $resource->getTableName('swstocklocation/boxes');
		$tableBo = 'sw_sl_box';

		// $tableSe = $resource->getTableName('swstocklocation/sections');
		$tableSe = 'sw_sl_section';


		$select = $write->select()
			->from(['l' => $tableL], ['l.id' ])
			->from(['z' => $tableZ], ['z.name AS zone'])
			->joinLeft(['bl' => $tableBl], 'l.id_block=bl.id', ['bl.name AS block'])
			->joinLeft(['sh' => $tableSh], 'l.id_shelf=sh.id', ['sh.name AS shelf'])
			->joinLeft(['box' => $tableBo], 'l.id_box=box.id', ['box.name AS box'])
			->joinLeft(['se' => $tableSe], 'l.id_section=se.id', ['se.name AS section'])
			->where('l.id_zone=z.id')
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
			//			$select->where(
			//				'l.id_zone IN ('. implode(',',$params['filter']['size']).')'
			//			);
		}

		$arLocation = $write->fetchAll($select);


		$locationsTable = '
			<h3>We have not locations which match filter\'s criteria.</h3> 
			<p>Please, try to change the filter.</p>
		';

		if (count($arLocation)>0) {
			$locationsTable ='
				<h3>'.count($arLocation).' available locations:</h3>
				<table>
					<thead>
						<tr>
							<td>First line</td>
							<td>Middle</td>
							<td>Back</td>
						</tr>					
					</thead>
					<tbody>
			';
			foreach ($arLocation AS $key => $location) {
				$locationsTable .='
						<tr>
							<td>'.$this->getLocationName($location).'</td>
							<td></td>
							<td></td>
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

	public function getLocationName ($rawLocationData) {
		$location = '';

		if (!is_null($rawLocationData['zone'])) {
			$location .= $rawLocationData['zone'];
		}
		if (!is_null($rawLocationData['block'])) {
			$location .= $rawLocationData['block'];
		}
		if (!is_null($rawLocationData['shelf'])) {
			$location .= '-'.$rawLocationData['shelf'];
		}
		if (!is_null($rawLocationData['box'])) {
			$location .= '/'.$rawLocationData['box'];
		}
		if (!is_null($rawLocationData['section'])) {
			$location .= $rawLocationData['section'];
		}

    	return $location;
	}

	public function getAjaxDefault () {
    	return 'unknown request';
	}
}
