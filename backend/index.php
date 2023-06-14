<?php
require_once 'config/database.php';
require_once 'class/Product.php';

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$products = Product::getAllProducts();

// Transform products to an array of product data
$productData = [];
foreach ($products as $product) {
    $productData[] = $product->getData();
}

echo json_encode($productData);
?>

