<?php

require_once 'class/Product.php';
require_once 'class/DVD.php';
require_once 'class/Book.php';
require_once 'class/Furniture.php';

class ProductFactory {
    private static $metadata = [
        'DVD' => [
            'class' => 'DVD',
            'props' => ['sku', 'name', 'price', 'size']
        ],
        'Book' => [
            'class' => 'Book',
            'props' => ['sku', 'name', 'price', 'weight']
        ],
        'Furniture' => [
            'class' => 'Furniture',
            'props' => ['sku', 'name', 'price', 'height', 'width', 'length']
        ]
    ];

    public static function createProduct($data) {
        $productType = $data['type'];

        if (!isset(self::$metadata[$productType])) {
            throw new Exception('Invalid product type');
        }

        $productMetadata = self::$metadata[$productType];
        $productClass = $productMetadata['class'];
        $productProps = $productMetadata['props'];

        $productData = [];
        foreach ($productProps as $prop) {
            if (!isset($data[$prop])) {
                throw new Exception("Missing product property: $prop");
            }
            $productData[$prop] = $data[$prop];
        }

        return new $productClass(...array_values($productData));
    }
}

