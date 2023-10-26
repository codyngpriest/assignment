<?php
class Book extends Product {
    private $weight;

    public function __construct($sku, $name, $price, $weight) {
        parent::__construct($sku, $name, $price);
        $this->weight = $weight;
    }

    public function setWeight($weight) {
        $this->weight = $weight;
    }

    public function save() {
        try {
            $db = $this->openConnection();

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

            $this->closeConnection($db); // Close the connection

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
        parent::display(); // Reuse the parent's display method
        echo "<strong>Weight:</strong> " . $this->getWeight() . " Kg";
        echo "</div>";
    }

    public function getProductType() {
        return "Book";
    }
}

