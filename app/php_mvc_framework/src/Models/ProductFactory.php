<?php
/**
 * A product factory to handle product creation
 * php version 8.1
 *
 * @category Custom_MVC
 * @package  MVC
 * @author   Vilho Banike <vilhopriestly@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @link     https://codyngpriest@github.com
 */
namespace Codyngpriest\PhpMvcFramework\Models;

use Codyngpriest\PhpMvcFramework\Models\DVDProduct;
use Codyngpriest\PhpMvcFramework\Models\BookProduct;
use Codyngpriest\PhpMvcFramework\Models\FurnitureProduct;
use Exception;


/**
 * Contains methods for creating different products
 * php version 8.1
 *
 * @category Custom_MVC
 * @package  MVC
 * @author   Vilho Banike <vilhopriestly@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @link     https://codyngpriest@github.com
 */
class ProductFactory
{
    private static $_metadata = [
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
    /**
     * A method to create a new product based on type
     *
     * @param $data              A props of the product to create
     * @param $productRepository A repository used to handle product creation
     *
     * @return The newly created product
     */
    public static function createProduct(
        $data,
        ProductRepository $productRepository
    ) {
        error_log("Received data: " . print_r($data, true));
        error_log("Creating product with data: " . print_r($data, true));
        $productType = $data['type'];

        if (!isset(self::$_metadata[$productType])) {
            throw new Exception('Invalid product type');
        }

        $productMetadata = self::$_metadata[$productType];
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
        return new $productClass(
            ...array_merge(array_values($productData), [$productRepository])
        );
    }
}

