<?php
require_once 'config/database.php';
require_once 'class/Product.php';

if (isset($_GET['sku'])) {
    // Single product deletion
    $sku = $_GET['sku'];

    if (Product::deleteProductBySKU($sku)) {
        echo "Product with SKU '$sku' has been deleted.";
    } else {
        echo "Failed to delete product with SKU '$sku'.";
    }
} elseif (isset($_POST['delete_selected'])) {
    // Mass delete operation
    if (isset($_POST['selected_products']) && is_array($_POST['selected_products'])) {
        $selectedProducts = $_POST['selected_products'];

        foreach ($selectedProducts as $productId) {
            if (Product::deleteProductById($productId)) {
                echo "Product with ID '$productId' has been deleted.<br>";
            } else {
                echo "Failed to delete product with ID '$productId'.<br>";
            }
        }
    } else {
        echo "No products selected for deletion.";
    }
} else {
    echo "Invalid operation.";
}
?>
