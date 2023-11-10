<?php
namespace Codyngpriest\PhpMvcFramework\Models;

use Codyngpriest\PhpMvcFramework\Database\DatabaseConnection;

class DVDProduct extends Product {
    private $size;

    public function __construct($sku, $name, $price, $size) {
        parent::__construct($sku, $name, $price);
        $this->size = $size;
    }

    public function setSize($size) {
        $this->size = $size;
    }

    public function getSize() {
        return $this->size;
    }

   public function save(ProductRepository $productRepository)
{
    try {
        $productRepository->saveDVDProduct($this);
        return true;
    } catch (\PDOException $e) {
        // Log or handle the error gracefully
        error_log("Error saving DVD: " . $e->getMessage());
        return false;
    }
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

    public function getProductType() {
        return "DVD";
    }
}

