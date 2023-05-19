<?php
require_once 'class/Product.php';

// Check if the SKU parameter is provided in the URL
if (isset($_GET['sku'])) {
    $sku = $_GET['sku'];

    // Retrieve the product details from the database
    $product = Product::getProductBySKU($sku);

    // Check if the product exists
    if ($product) {
        echo "<h2>Product Details</h2>";
        echo "<p><strong>SKU:</strong> " . $product['sku'] . "</p>";
        echo "<p><strong>Name:</strong> " . $product['name'] . "</p>";
        echo "<p><strong>Price:</strong> " . $product['price'] . "</p>";
    } else {
        echo "Product not found.";
    }
} else {
    echo "Invalid request.";
}
?>

