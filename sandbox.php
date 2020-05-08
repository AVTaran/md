<?php

require_once "app/Mage.php";

Mage::app();
umask(0);
ini_set('display_errors', 1);



$ret = array();
$arLocations = $arUnmatchedRecords = array();

// require_once (Mage::getBaseDir().DS.'integration'.DS.'lib'.DS.'reader.php');
$pathOfDirI = Mage::getBaseDir().DS.'integration'.DS;
$pathOfFileLocation = $pathOfDirI.'ShelfLocationExport-04May2020.xlsx';
if( !file_exists($pathOfFileLocation)) {
	return $ret;
}

require_once ($pathOfDirI.'lib'.DS.'vendor'.DS.'autoload.php');


$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
$spreadsheet = $reader->load($pathOfFileLocation);

$sheetData = $spreadsheet
	->getActiveSheet()
	->toArray(null, true, true, true)
;
// print_r($sheetData);


array_shift($sheetData);
$ret['totalRows'] = count($sheetData);

// $sheetData = array_splice($sheetData, $params['number']);
//$sheetdata = array_slice(
	//$sheetdata,
	//($params['number']*($params['portion']-1)),
	//$params['number']
//);

// $sheetData = $sheetData[$params['portion']];

foreach ($sheetData AS $r => $rowData) {
	foreach ($rowData AS $c => $cellData) {
		$cellData = trim($cellData);
		if ($cellData=='') {
			continue;
		}
		$arUnmatchedRecords[] = $cellData;

		// M1-1-98/108
		if (preg_match('/(M)([1|4|5]-[1|2|3])-(\d+)\/?(\d+)?/m', $cellData, $out)) {
			$arLocations[] = array($out[0],$out[1],$out[2],$out[3]);
			if ( isset($out[4]) AND $out[4]!='' ) {
				$arLocations[] = array($out[0],$out[1],$out[2],$out[4]);
			}
			array_pop($arUnmatchedRecords);
			continue;
		}

		$arPatterns = array (
			// M8-1-50/3A, O4-2B-40/4A,
			'/([M|O|U|P|N])(\d+-\d+[A|B]?)-?(\d+)\/(\d+)(\w*)/mi',

			// S-IR1-E-A1, S-WR3-B-F12, S-IR6-E-20/A, S-IR5-A-30
			'/^(S)-(\w+?\d+)-(\w+)-(\D+)?(\d+)\/?(\D)?$/mi',

			// O1-1-N1, O1-1-GAP
			// S-ROD, S-CR2
			// S-AR9-T, S-AR9-B
			// S-CG1-B-A5, S-CG1-D-10
			// Freezer-1
			// C2-40-L/F, C2-40-M/F, C2-50-R
		);

		foreach ($arPatterns AS $p => $pattern) {
			if (preg_match ($pattern, $cellData, $out)) {
				foreach ($out AS $i => $v){
					if (is_null($v) or $v==''){
						unset ($out[$i]);
					}
				}
				$out = array_pad($out,6,null);
				// echo '<pre>';
				// print_r($out);
				// echo '</pre>';
				$arLocations[] = $out;
				array_pop($arUnmatchedRecords);
				break;
			}
		}

		if ($c==0) {
			array_pop($arUnmatchedRecords);
		}
	}
}

// new locations are added to file
$fp = fopen($pathOfDirI.DS.'arLocations.txt', 'w');
if (count($arLocations)>0){
	foreach ($arLocations AS $k => $location) {
		$location = array_pad($location,6,null);
		fwrite($fp, $location[0]."\n");
	}
}
fclose($fp);

$fp = fopen($pathOfDirI.DS.'arUnmatchedRecords.txt', 'w');
if (count($arUnmatchedRecords)>0){
	foreach ($arUnmatchedRecords AS $k => $location) {
		fwrite($fp, $location[0]."\n");
	}
}
fclose($fp);



//$ret['arLocations'] = $arLocations;
$ret['arUnmatchedRecords'] = $arUnmatchedRecords;
if (count($sheetData)<$params['number']) {
	$ret['completeRows'] = $ret['totalRows'];
} else {
	$ret['completeRows'] = count($sheetData)*$params['portion'];
}

echo '<pre>';
print_r ($ret);
echo '</pre>';





/*

// test your stuffs
// $productModel = Mage::getModel("catalog/product")->load();

$pattern = '/(S)-(\w+?\d+)-(\w+)-(\D+)?(\d+)?\/?(\D)?/mi';

// $pattern = '/(S)/mi';
$cellData = 'S-IR5-E-30';
preg_match ($pattern, $cellData, $out);

foreach ($out AS $i => $v){
	if (is_null($v) or $v==''){
		unset ($out[$i]);
	}
}
$out = array_pad($out,6,null);
echo '<pre>';
print_r($out);
echo '</pre>';


/*

$queryName = 'msj006c';

$productModel = Mage::getModel('catalog/product')
	->getCollection()
	->addAttributeToSelect('*')
	// ->addCategoryFilter($category)
	// ->addAttributeToFilter('sku', array('in' => $skuList))
	->addAttributeToFilter(
		'sku',
		array (
			'like' => '%'.$queryName.'%'
		)
	)

	->addAttributeToFilter(
		'name',
		array(
			array('like' => '% '.$queryName.' %'), //spaces on each side
			array('like' => '% '.$queryName), //space before and ends with $needle
			array('like' => $queryName.' %') // starts with needle and space after
		)
	)
	->addAttributeToFilter(
		['name', 'sku'],
		[
			['like' => '%'.$queryName.'%'],
			['like' => '%'.$queryName.'%']
		])

	->getFirstItem()
;

$productId = $productModel->getID();

if ($productId) {
	$product = Mage::getModel('catalog/product')->load($productId);
	if ($product) {
		echo '<pre>';
		print_r($product);
		echo '</pre>';
		// $this->setProduct($product);
	} else{
		echo '! $product ';
	}
} else{
	echo '! $product Id ';
}









$sAttributeName = 'size';
$mOptionValue = 'medium';
$collection = Mage::getModel('catalog/product')->getCollection()
	->addAttributeToSelect('*')
	->addFieldToFilter(
		$sAttributeName,
		array(
			'eq' => Mage::getResourceModel('catalog/product')
				->getAttribute($sAttributeName)
				->getSource()
				->getOptionId($mOptionValue)
		)
	);
*/