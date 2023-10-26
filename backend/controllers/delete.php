<?php

// Create an instance of the controller
$controller = new ProductsContr(new Product());

// Process the request to delete a product
$controller->deleteProduct($_POST); 

?>

