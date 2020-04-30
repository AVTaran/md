<?php

require_once "app/Mage.php";

Mage::app();
umask(0);
ini_set('display_errors', 1);



// test your stuffs
// $productModel = Mage::getModel("catalog/product")->load();

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

	/*
	->addAttributeToFilter(
		'name',
		array(
			array('like' => '% '.$queryName.' %'), //spaces on each side
			array('like' => '% '.$queryName), //space before and ends with $needle
			array('like' => $queryName.' %') // starts with needle and space after
		)
	)
	*/
	/*
	->addAttributeToFilter(
		['name', 'sku'],
		[
			['like' => '%'.$queryName.'%'],
			['like' => '%'.$queryName.'%']
		])
	*/
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


/*
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