<?php

// Create an instance of the controller
$controller = new ProductsContr(new Product());

// Process the request to create a new product
$controller->createProductFromRequest();
?>

