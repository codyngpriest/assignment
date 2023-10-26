<?php

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

    // Getters and setters for encapsulation.
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

    // These abstract methods represent actions that will be implemented in concrete product classes.
    abstract public function save();
    abstract public function display();
    abstract public function getProductType(); // New abstract method
}

