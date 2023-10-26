<?php

// Create an instance of the controller
$controller = new ProductsContr(new Product());

// Retrieve products using the controller
$products = $controller->getProducts();

// Send the response as JSON
header('Content-Type: application/json');
echo json_encode($products);

