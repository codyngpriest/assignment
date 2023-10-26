<?php

class Furniture extends Product {
    protected $height;
    protected $width;
    protected $length;

    public function __construct($sku, $name, $price, $height, $width, $length) {
        parent::__construct($sku, $name, $price);
        $this->height = $height;
        $this->width = $width;
        $this->length = $length;
    }

    public function setDimensions($height, $width, $length) {
        $this->height = $height;
        $this->width = $width;
        $this->length = $length;
    }

    public function getDimensions() {
        return "Height: " . $this->height . " cm, Width: " . $this->width . " cm, Length: " . $this->length . " cm";
    }

    public function save() {
        try {
            $db = $this->openConnection();

            // Insert product into the 'products' table
            $query = "INSERT INTO products (sku, name, price, type) VALUES (?, ?, ?, ?)";
            $stmt = $db->prepare($query);
            $stmt->execute([$this->sku, $this->name, $this->price, 'Furniture']);

            // Get the ID of the newly inserted product
            $this->id = $db->lastInsertId();

            // Insert Furniture-specific attributes into the 'furniture_products' table
            $query = "INSERT INTO furniture_products (id, height, width, length) VALUES (?, ?, ?, ?)";
            $stmt = $db->prepare($query);
            $stmt->execute([$this->id, $this->height, $this->width, $this->length]);

            $this->closeConnection($db); // Close the connection

            return true;
        } catch (PDOException $e) {
            // Log or handle the error gracefully
            error_log("Error saving Furniture: " . $e->getMessage());
            return false;
        }
    }

    public function display() {
        echo "<div>";
        echo "<strong>Product Type:</strong> Furniture";
        echo "<br>";
        parent::display(); // Reuse the parent's display method
        echo "<strong>Dimensions:</strong> " . $this->getDimensions();
        echo "</div>";
    }

    public function getProductType() {
        return "Furniture";
    }
}

