<?php
require_once 'class/Product.php';


// Check if the SKU parameter is provided in the URL
if (isset($_GET['sku'])) {
    $sku = $_GET['sku'];

    // Retrieve the product details from the database
    $product = Product::getProductBySKU($sku);

    // Check if the product exists
    if ($product) {
        // Return the product details as JSON
        echo json_encode($product);
    } else {
        // Return an error message
        echo json_encode(['error' => 'Product not found.']);
    }
} else {
    // Return an error message
    echo json_encode(['error' => 'Invalid request.']);
}
?>

