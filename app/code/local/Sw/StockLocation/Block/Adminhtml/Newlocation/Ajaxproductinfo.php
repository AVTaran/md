<?php


class Sw_StockLocation_Block_Adminhtml_Newlocation_Ajaxproductinfo extends  Mage_Adminhtml_Block_Abstract
{
    protected function _construct() {
        parent::_construct();
		$this->setTemplate('swstocklocation/newlocation_ajaxproductinfo.phtml');
    }

	public function getLocationsOfProduct ($idProd)
	{
		// TODO: just for test
		// $idProd = 231;

		$resource = Mage::getSingleton('core/resource');
		$connection = $resource->getConnection('core_read');


		$tableLp = 'sw_sl_location_product';

		// $tableL  = $resource->getTableName('swstocklocation/locations');
		$tableL = 'sw_sl_location';
		// $tableL = $this->getTable('swstocklocation/table_location');

		// $tableZ  = $resource->getTableName('swstocklocation/zones');
		$tableZ = 'sw_sl_zone';

		// $tableBl = $resource->getTableName('swstocklocation/blocks');
		$tableBl = 'sw_sl_block';

		// $tableSh = $resource->getTableName('swstocklocation/shelfs');
		$tableSh = 'sw_sl_shelf';

		// $tableBo = $resource->getTableName('swstocklocation/boxes');
		$tableBo = 'sw_sl_box';

		// $tableSe = $resource->getTableName('swstocklocation/sections');
		$tableSe = 'sw_sl_section';


		$select = $connection->select()
			->from		(['l'  	=> $tableL],  ['l.id'])
			->from		(['lp' 	=> $tableLp], ['lp.qty', 'lp.qty_estimated'])
			->from		(['z'  	=> $tableZ],  ['z.name AS zone'])
			->joinLeft	(['bl' 	=> $tableBl], 'l.id_block=bl.id', ['bl.name AS block'])
			->joinLeft	(['sh' 	=> $tableSh], 'l.id_shelf=sh.id', ['sh.name AS shelf'])
			->joinLeft	(['box' => $tableBo], 'l.id_box=box.id', ['box.name AS box'])
			->joinLeft	(['se' 	=> $tableSe], 'l.id_section=se.id', ['se.name AS section'])
			->where		('z.id		= l.id_zone')
			->where		('l.id		= lp.id_location')
			->where		($idProd.' 	= lp.id_product')
			// ->limit		(10)
		;
		// echo $select;

		// return $select;

		$arLocations = $connection->fetchAll($select);

		return $arLocations;
	}

}

