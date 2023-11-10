<?php

namespace Codyngpriest\PhpMvcFramework\Models;

abstract class Product
{
    protected $id;
    protected $sku;
    protected $name;
    protected $price;

    public function __construct($sku, $name, $price)
    {
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

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getID() {
        return $this->id;
    }

    abstract public function save(ProductRepository $productRepository);
    abstract public function display();
    abstract public function getProductType();

    public function deleteProduct() {
        error_log("Deleting product with ID: " . $this->id);
    }

}

