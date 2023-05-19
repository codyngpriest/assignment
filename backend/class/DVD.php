<?php
require_once 'Product.php';

class DVD extends Product {
    private $size;
    private $duration;

    public function setSize($size) {
        $this->size = $size;
    }

    public function getSize() {
        return $this->size;
    }

    public function setDuration($duration) {
        $this->duration = $duration;
    }

    public function getDuration() {
        return $this->duration;
    }

    public function save() {
        $database = new DB();
        $db = $database->getConnection();

        // Insert product into the 'products' table
        $query = "INSERT INTO products (sku, name, price, type) VALUES (?, ?, ?, 'DVD')";
        $stmt = $db->prepare($query);
        $stmt->execute([$this->sku, $this->name, $this->price]);

        // Get the ID of the newly inserted product
        $this->id = $db->lastInsertId();

        // Insert DVD-specific attributes into the 'dvd_products' table
        $query = "INSERT INTO dvd_products (id, size, duration) VALUES (?, ?, ?)";
        $stmt = $db->prepare($query);
        $stmt->execute([$this->id, $this->size, $this->duration]);

        return true;
    }

    public function display() {
        echo "SKU: " . $this->sku . "<br>";
        echo "Name: " . $this->name . "<br>";
        echo "Price: " . $this->price . "<br>";
        echo "Size: " . $this->size . "<br>";
        echo "Duration: " . $this->duration . "<br>";
    }
}

?>


