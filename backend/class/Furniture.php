<?php
require_once 'Product.php';

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
        $database = new DB();
        $db = $database->getConnection();

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

        return true;
    }

    public function display() {
        echo "SKU: " . $this->sku . "<br>";
        echo "Name: " . $this->name . "<br>";
        echo "Price: " . $this->price . "<br>";
        echo "Dimensions: " . $this->getDimensions() . "<br>";
    }
}
?>

