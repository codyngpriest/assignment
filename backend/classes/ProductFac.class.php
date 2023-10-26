<?php


class ProductFactory {
    public static function createProduct($data, $productType) {
        // Ensure the product class exists
        $productClass = 'Product' . $productType;
        if (!class_exists($productClass)) {
            throw new Exception('Invalid product type');
        }

        // Create an instance of the product class
        return new $productClass($data);
    }
}

