<?php
require_once 'config/database.php';

// Enable CORS
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

abstract class Product {
    protected $id;
    protected $sku;
    protected $name;
    protected $price;

    public function __construct($sku, $name, $price) {
        $this->sku = $sku;
        $this->name = $name;
        $this->price = $price;
    }

    public function setSKU($sku) {
        $this->sku = $sku;
    }

    public function getSKU() {
        return $this->sku;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getName() {
        return $this->name;
    }

    public function setPrice($price) {
        $this->price = $price;
    }

    public function getPrice() {
        return $this->price;
    }

    public function getID() {
        return $this->id;
    }

    abstract public function save();
    abstract public function display();

    public static function getAllProducts() {
        $db = DB::getInstance();
        $conn = $db->getConnection();

        $stmt = $conn->prepare("SELECT * FROM products ORDER BY id ASC");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getProductBySKU($sku) {
        $db = DB::getInstance();
        $conn = $db->getConnection();

        $stmt = $conn->prepare("SELECT * FROM products WHERE sku = :sku");
        $stmt->bindParam(':sku', $sku);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function deleteProductBySKU($sku) {
        $db = DB::getInstance();
        $conn = $db->getConnection();

        $stmt = $conn->prepare("DELETE FROM products WHERE sku = :sku");
        $stmt->bindParam(':sku', $sku);

        return $stmt->execute();
    }

    public static function deleteProductById($id) {
        $db = DB::getInstance();
        $conn = $db->getConnection();

        $stmt = $conn->prepare("DELETE FROM products WHERE id = :id");
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }

    public static function isSKUUnique($sku) {
        $db = DB::getInstance();
        $conn = $db->getConnection();

        $stmt = $conn->prepare("SELECT COUNT(*) FROM products WHERE sku = :sku");
        $stmt->bindParam(':sku', $sku);
        $stmt->execute();

        return $stmt->fetchColumn() == 0;
    }
}
?>

