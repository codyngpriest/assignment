<?php
require_once 'config/database.php';
require_once 'class/Product.php';

$products = Product::getAllProducts();

echo json_encode($products);
?>
