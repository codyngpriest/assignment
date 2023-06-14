<?php
require_once 'config/database.php';
require_once 'class/Product.php';

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE');
header('Access-Control-Allow-Headers: Content-Type');
header('Cache-Control: no-store');

if (isset($_GET['sku'])) {
    // Single product deletion
    $sku = $_GET['sku'];

    if (Product::deleteProductBySKU($sku)) {
        echo "Product with SKU '$sku' has been deleted.";
    } else {
        echo "Failed to delete product with SKU '$sku'.";
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    // Mass delete operation
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['skus']) && is_array($data['skus'])) {
        $selectedSkus = $data['skus'];

        foreach ($selectedSkus as $sku) {
            if (Product::deleteProductBySKU($sku)) {
                echo "Product with SKU '$sku' has been deleted.<br>";
            } else {
                echo "Failed to delete product with SKU '$sku'.<br>";
            }
        }
    } else {
        echo "No products selected for deletion.";
    }
} else {
    echo "Invalid operation.";
}
?>

