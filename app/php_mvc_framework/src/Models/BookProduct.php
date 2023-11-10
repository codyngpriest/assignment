<?php

namespace Codyngpriest\PhpMvcFramework\Models;

use Codyngpriest\PhpMvcFramework\Database\DatabaseConnection;

class BookProduct extends Product
{
    private $weight;

    public function __construct($sku, $name, $price, $weight)
    {
        parent::__construct($sku, $name, $price);
        $this->weight = $weight;
    }

    public function setWeight($weight)
    {
        $this->weight = $weight;
    }

    public function getWeight()
    {
        return $this->weight;
    }

  public function save(ProductRepository $productRepository)
{
    try {
        $productRepository->saveBookProduct($this);
        return true;
    } catch (\PDOException $e) {
        // Log or handle the error gracefully
        error_log("Error saving Book: " . $e->getMessage());
        return false;
    }
}


    public function display()
    {
        echo "<div>";
        echo "<strong>Product Type:</strong> Book";
        echo "<br>";
        echo "<strong>SKU:</strong> " . $this->getSKU();
        echo "<br>";
        echo "<strong>Name:</strong> " . $this->getName();
        echo "<br>";
        echo "<strong>Price:</strong> " . $this->getPrice() . " $";
        echo "<br>";
        echo "<strong>Weight:</strong> " . $this->getWeight() . " Kg";
        echo "</div>";
    }

    public function getProductType()
    {
        return "Book";
    }
}

