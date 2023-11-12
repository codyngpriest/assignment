<?php
/**
 * A product repository for performing generic product actions
 * Handles DB connections and operations
 * php version 8.1
 *
 * @category Custom_MVC
 * @package  MVC
 * @author   Vilho Banike <vilhopriestly@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @link     https://codyngpriest@github.com
 */

namespace Codyngpriest\PhpMvcFramework\Models;

use Codyngpriest\PhpMvcFramework\Database\DatabaseConnection;
use PDO;


/**
 * Contains methods for performing products actions
 * Handles DB connections and operations
 * php version 8.1
 *
 * @category Custom_MVC
 * @package  MVC
 * @author   Vilho Banike <vilhopriestly@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @link     https://codyngpriest@github.com
 */
class ProductRepository
{
    protected $table = 'products';
    protected $dbConnection;
    /**
     * Handles DB interactions
     *
     * @param $dbConnection A variable for instantiating DB connection
     *
     * @return void
     */
    public function __construct(DatabaseConnection $dbConnection)
    {
        $this->dbConnection = $dbConnection;
    }
    /**
     * Deletes a product from DB by its id
     *
     * @param $id The id of the product to be deleted
     *
     * @return void
     */
    public function deleteProductById($id)
    {
        $conn = $this->dbConnection->openConnection();

        $query = "DELETE FROM $this->table WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $id);

        try {
            $result = $stmt->execute();
            $this->dbConnection->closeConnection($conn);
            return $result;
        } catch (\PDOException $e) {
            error_log("Error deleting product: " . $e->getMessage());
            throw $e;
        }
    }
    /**
     * Gets a product from DB by its id
     *
     * @param $id The id of the product to get
     *
     * @return void
     */
    public function getProductById($id)
    {
        $conn = $this->dbConnection->openConnection();

        $query = "SELECT * FROM $this->table WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $productData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($productData) {
            $this->dbConnection->closeConnection($conn);
            return ProductFactory::createProduct($productData);
        } else {
            $this->dbConnection->closeConnection($conn);
            return null;
        }
    }
    /**
     * A save method to save a Book product to DB
     *
     * @param $bookProduct Represents a Book
     *
     * @return void
     */
    public function saveBookProduct(BookProduct $bookProduct)
    {
        $conn = $this->dbConnection->openConnection();

        // Insert product into the 'products' table
        $query = "INSERT INTO products (sku, name, price, type) " .
                 "VALUES (?, ?, ?, 'Book')";
        $stmt = $conn->prepare($query);
        $stmt->execute(
            [
            $bookProduct->getSKU(),
            $bookProduct->getName(),
            $bookProduct->getPrice()
            ]
        );

        // Get the ID of the newly inserted product
        $bookProduct->setId($conn->lastInsertId());

        // Insert Book-specific attributes into the 'book_products' table
        $query = "INSERT INTO book_products (id, weight) VALUES (?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->execute([$bookProduct->getId(), $bookProduct->getWeight()]);

        $this->dbConnection->closeConnection($conn);
    }
     /**
      * A save method to save a DVD product to DB
      *
      * @param $dvdProduct Represents a DVD
      *
      * @return void
      */
    public function saveDVDProduct(DVDProduct $dvdProduct)
    {
        $conn = $this->dbConnection->openConnection();

        // Insert product into the 'products' table
        $query = "INSERT INTO products (sku, name, price, type) " .
                 "VALUES (?, ?, ?, 'DVD')";
        $stmt = $conn->prepare($query);
        $stmt->execute(
            [
            $dvdProduct->getSKU(),
            $dvdProduct->getName(),
            $dvdProduct->getPrice()
            ]
        );

        // Get the ID of the newly inserted product
        $dvdProduct->setId($conn->lastInsertId());

        // Insert DVD-specific attributes into the 'dvd_products' table
        $query = "INSERT INTO dvd_products (id, size) VALUES (?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->execute([$dvdProduct->getId(), $dvdProduct->getSize()]);

        $this->dbConnection->closeConnection($conn);
    }
     /**
      * A save method to save a Furniture product to DB
      *
      * @param $furnitureProduct Represents a Furniture
      *
      * @return void
      */
    public function saveFurnitureProduct(FurnitureProduct $furnitureProduct)
    {
        $conn = $this->dbConnection->openConnection();

        // Insert product into the 'products' table
        $query = "INSERT INTO products (sku, name, price, type) " .
             "VALUES (?, ?, ?, 'Furniture')";
        $stmt = $conn->prepare($query);
        $stmt->execute(
            [
            $furnitureProduct->getSKU(),
            $furnitureProduct->getName(),
            $furnitureProduct->getPrice()
            ]
        );

        // Get the ID of the newly inserted product
        $furnitureProduct->setId($conn->lastInsertId());

        // Explode dimensions into separate variables
        list($height, $width, $length) = $this->_extractDimensions(
            $furnitureProduct->getDimensions()
        );

        // Insert Furniture-specific attributes into the 'furniture_products' table
        $query = "INSERT INTO furniture_products (id, height, width, length) " .
             "VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->execute(
            [
            $furnitureProduct->getId(),
            $height,
            $width,
            $length
            ]
        );

        $this->dbConnection->closeConnection($conn);
    }
    /**
     * Extract dimensions from the string
     *
     * @param string $dimensionsString The dimensions string.
     *
     * @return array An array containing height, width, and length.
     */
    private function _extractDimensions($dimensionsString)
    {
        // Extract numbers using a regular expression
        preg_match_all(
            '/Height:\s*(\d+(\.\d+)?)\s*cm,\s*Width:\s*'
            . '(\d+(\.\d+)?)\s*cm,\s*Length:\s*(\d+(\.\d+)?)\s*cm/',
            $dimensionsString,
            $matches
        );

        // If matches were found, return them
        if (count($matches) === 7) {
            return [$matches[1][0], $matches[3][0], $matches[5][0]];
        }

        // Return default values or handle the error as needed
        return [0, 0, 0];
    }

     /**
      * A method to get all products from DB
      *
      * @return void
      */
    public function getAllProducts()
    {
        try {
            $conn = $this->dbConnection->openConnection();

            $query = "SELECT p.*, d.size, b.weight, f.length, f.width, f.height
                  FROM products p
                  LEFT JOIN dvd_products d ON p.id = d.id
                  LEFT JOIN book_products b ON p.id = b.id
                  LEFT JOIN furniture_products f ON p.id = f.id";

            $stmt = $conn->prepare($query);
            $stmt->execute();
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $this->dbConnection->closeConnection($conn);

            return $products;
        } catch (PDOException $e) {
            // Handle database connection error
            error_log("Database connection error: " . $e->getMessage());
            throw $e;
        }
    }

}

