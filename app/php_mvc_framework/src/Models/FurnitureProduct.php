<?php
namespace Codyngpriest\PhpMvcFramework\Models;

use Codyngpriest\PhpMvcFramework\Database\DatabaseConnection;

class FurnitureProduct extends Product {
    private $height;
    private $width;
    private $length;

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

    public function save(ProductRepository $productRepository)
{
    try {
        $productRepository->saveFurnitureProduct($this);
        return true;
    } catch (\PDOException $e) {
        // Log or handle the error gracefully
        error_log("Error saving Furniture: " . $e->getMessage());
        return false;
    }
}


    public function display() {
        echo "<div>";
        echo "<strong>Product Type:</strong> Furniture";
        echo "<br>";
        echo "<strong>SKU:</strong> " . $this->getSKU();
        echo "<br>";
        echo "<strong>Name:</strong> " . $this->getName();
        echo "<br>";
        echo "<strong>Price:</strong> " . $this->getPrice() . " $";
        echo "<br>";
        echo "<strong>Dimensions:</strong> " . $this->getDimensions();
        echo "</div>";
    }

    public function getProductType() {
        return "Furniture";
    }
}

