<?php
require_once 'Product.php';

class Book extends Product {
    private $weight;

    public function setWeight($weight) {
        $this->weight = $weight;
    }

    public function getWeight() {
        return $this->weight;
    }

    public function save() {
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
    }

    public function display() {
        echo "SKU: " . $this->sku . "<br>";
        echo "Name: " . $this->name . "<br>";
        echo "Price: " . $this->price . "<br>";
        echo "Weight: " . $this->weight . "<br>";
    }
}

?>

