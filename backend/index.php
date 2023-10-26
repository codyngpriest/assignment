<?php

require_once __DIR__ . '/includes/class-autoload.inc.php';

// Create an instance of the controller
$controller = new ProductsContr(new Product());

// Retrieve products using the controller
$products = $controller->getProducts();

// Send the response as JSON
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
echo json_encode($products);

