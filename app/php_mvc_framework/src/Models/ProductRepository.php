<?php

namespace Codyngpriest\PhpMvcFramework\Models;

use Codyngpriest\PhpMvcFramework\Database\DatabaseConnection;
use PDO;

class ProductRepository
{
    protected $table = 'products';
    protected $dbConnection;

    public function __construct(DatabaseConnection $dbConnection)
    {
        $this->dbConnection = $dbConnection;
    }

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

    public function saveBookProduct(BookProduct $bookProduct)
    {
        $conn = $this->dbConnection->openConnection();

        // Insert product into the 'products' table
        $query = "INSERT INTO products (sku, name, price, type) VALUES (?, ?, ?, 'Book')";
        $stmt = $conn->prepare($query);
        $stmt->execute([$bookProduct->getSKU(), $bookProduct->getName(), $bookProduct->getPrice()]);

        // Get the ID of the newly inserted product
        $bookProduct->setId($conn->lastInsertId());

        // Insert Book-specific attributes into the 'book_products' table
        $query = "INSERT INTO book_products (id, weight) VALUES (?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->execute([$bookProduct->getId(), $bookProduct->getWeight()]);

        $this->dbConnection->closeConnection($conn);
    }

    public function saveDVDProduct(DVDProduct $dvdProduct)
    {
        $conn = $this->dbConnection->openConnection();

        // Insert product into the 'products' table
        $query = "INSERT INTO products (sku, name, price, type) VALUES (?, ?, ?, 'DVD')";
        $stmt = $conn->prepare($query);
        $stmt->execute([$dvdProduct->getSKU(), $dvdProduct->getName(), $dvdProduct->getPrice()]);

        // Get the ID of the newly inserted product
        $dvdProduct->setId($conn->lastInsertId());

        // Insert DVD-specific attributes into the 'dvd_products' table
        $query = "INSERT INTO dvd_products (id, size) VALUES (?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->execute([$dvdProduct->getId(), $dvdProduct->getSize()]);

        $this->dbConnection->closeConnection($conn);
    }

    public function saveFurnitureProduct(FurnitureProduct $furnitureProduct)
    {
        $conn = $this->dbConnection->openConnection();

        // Insert product into the 'products' table
        $query = "INSERT INTO products (sku, name, price, type) VALUES (?, ?, ?, 'Furniture')";
        $stmt = $conn->prepare($query);
        $stmt->execute([$furnitureProduct->getSKU(), $furnitureProduct->getName(), $furnitureProduct->getPrice()]);

        // Get the ID of the newly inserted product
        $furnitureProduct->setId($conn->lastInsertId());

        // Insert Furniture-specific attributes into the 'furniture_products' table
        $query = "INSERT INTO furniture_products (id, height, width, length) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->execute([$furnitureProduct->getId(), $furnitureProduct->getDimensions()]);
        //$stmt->execute([$furnitureProduct->getId(), $furnitureProduct->getHeight(), $furnitureProduct->getWidth(), $furnitureProduct->getLength()]);

        $this->dbConnection->closeConnection($conn);
    }
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

