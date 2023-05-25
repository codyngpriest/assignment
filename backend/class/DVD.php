<?php
require_once 'Product.php';

// Allow cross-origin requests
header('Access-Control-Allow-Origin: http://localhost:5173');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header("Access-Control-Allow-Credentials: true");

class DVD extends Product {
    private $size;

    public function __construct($sku, $name, $price) {
        parent::__construct($sku, $name, $price);
    }

    public function setSize($size) {
        $this->size = $size;
    }

    public function getSize() {
        return $this->size;
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
        $query = "INSERT INTO dvd_products (id, size) VALUES (?, ?)";
        $stmt = $db->prepare($query);
        $stmt->execute([$this->id, $this->size]);

        return true;
    }

        public function display() {
        echo "<div>";
        echo "<strong>Product Type:</strong> DVD";
        echo "<br>";
        echo "<strong>SKU:</strong> " . $this->getSKU();
        echo "<br>";
        echo "<strong>Name:</strong> " . $this->getName();
        echo "<br>";
        echo "<strong>Price:</strong> " . $this->getPrice() . " $";
        echo "<br>";
        echo "<strong>Size:</strong> " . $this->getSize() . " MB";
        echo "</div>";
    }
}

?>


