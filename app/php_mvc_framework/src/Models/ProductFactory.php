<?php
namespace Codyngpriest\PhpMvcFramework\Models;

use Codyngpriest\PhpMvcFramework\Models\DVDProduct;
use Codyngpriest\PhpMvcFramework\Models\BookProduct;
use Codyngpriest\PhpMvcFramework\Models\FurnitureProduct;
use Exception;

class ProductFactory {
   private static $metadata = [
    'DVD' => [
        'class' => DVDProduct::class,
        'props' => ['sku', 'name', 'price', 'size']
    ],
    'Book' => [
        'class' => BookProduct::class,
        'props' => ['sku', 'name', 'price', 'weight']
    ],
    'Furniture' => [
        'class' => FurnitureProduct::class,
        'props' => ['sku', 'name', 'price', 'height', 'width', 'length']
    ]
];

    public static function createProduct($data, ProductRepository $productRepository) {
        error_log("Received data: " . print_r($data, true));
        error_log("Creating product with data: " . print_r($data, true));
        $productType = $data['type'];

        if (!isset(self::$metadata[$productType])) {
            throw new Exception('Invalid product type');
        }

        $productMetadata = self::$metadata[$productType];
        $productClass = $productMetadata['class'];
        $productProps = $productMetadata['props'];

        // Check for missing properties
        foreach ($productProps as $prop) {
            if (!isset($data[$prop])) {
                throw new Exception("Missing product property: $prop");
            }
            $productData[$prop] = $data[$prop];
        }

        error_log("Creating product with data: " . print_r($productData, true));
         //return new $productClass(...array_merge(array_values($productData), [$productRepository]));  
         //return new $productClass(...array_values($productData), $productRepository);
         return new $productClass(...array_merge(array_values($productData), [$productRepository]));
    }
}

