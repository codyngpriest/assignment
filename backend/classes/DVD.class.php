<?php
class DVD extends Product {
    private $size;

    public function __construct($sku, $name, $price, $size) {
        parent::__construct($sku, $name, $price);
        $this->size = $size;
    }

    public function setSize($size) {
        $this->size = $size;
    }

    public function save() {
        try {
            $db = $this->openConnection();

            // Insert product into the 'products' table
            $query = "INSERT INTO products (sku, name, price, type) VALUES (?, ?, ?, 'DVD')";
            $stmt = $db->prepare($query);
            $stmt->execute([$this->sku, $this->name, $this->price]);

            // Get the ID of the newly inserted product
            $this->id = $db->lastInsertId();

            // Insert DVD-specific attributes into the 'dvd_products' table
            $query = "INSERT INTO dvd_products (id, size) VALUES (?, ?)";
            $stmt = $db->prepare($query);
            $stmt->execute([$this->id, $this->size]);

            $this->closeConnection($db); // Close the connection

            return true;
        } catch (PDOException $e) {
            // Log or handle the error gracefully
            error_log("Error saving DVD: " . $e->getMessage());
            return false;
        }
    }

    public function display() {
        echo "<div>";
        echo "<strong>Product Type:</strong> DVD";
        echo "<br>";
        parent::display(); // Reuse the parent's display method
        echo "<strong>Size:</strong> " . $this->getSize() . " MB";
        echo "</div>";
    }

    public function getProductType() {
        return "DVD";
    }
}

