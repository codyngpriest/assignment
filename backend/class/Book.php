<?php
require_once 'Product.php';

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type');
header('Cache-Control: no-store');

class Book extends Product {
    private $weight;

    public function __construct($sku, $name, $price, $weight) {
	    parent::__construct($sku, $name, $price);
	    $this->weight = $weight;
    }

    public function setWeight($weight) {
        $this->weight = $weight;
    }

    public function getWeight() {
        return $this->weight;
    }

    public function save()
    {
        try {
            $database = new DB();
            $db = $database->getConnection();

            // Insert product into the 'products' table
            $query = "INSERT INTO products (sku, name, price, type) VALUES (?, ?, ?, 'Book')";
            $stmt = $db->prepare($query);
            $stmt->execute([$this->sku, $this->name, $this->price]);

            // Get the ID of the newly inserted product
            $this->id = $db->lastInsertId();

            // Insert Book-specific attributes into the 'book_products' table
            $query = "INSERT INTO book_products (id, weight) VALUES (?, ?)";
            $stmt = $db->prepare($query);
            $stmt->execute([$this->id, $this->weight]);

            return true;
        } catch (PDOException $e) {
            // Log or handle the error gracefully
            error_log("Error saving Book: " . $e->getMessage());
            return false;
        }
    }

    public function display() {
        echo "<div>";
        echo "<strong>Product Type:</strong> Book";
        echo "<br>";
        echo "<strong>SKU:</strong> " . $this->getSKU();
        echo "<br>";
        echo "<strong>Name:</strong> " . $this->getName();
        echo "<br>";
        echo "<strong>Price:</strong> " . $this->getPrice() . " $";
        echo "<br>";
        echo "<strong>Weight:</strong> " . $this->getWeight() . " Kg";
        echo "</div>";
    }

    public function getProductType() {
        return "Book";
    }
}
?>

