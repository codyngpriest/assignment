<?php

class FurnitureView {
    public function render(Furniture $furniture) {
        echo "<div>";
        echo "<strong>Product Type:</strong> Furniture";
        echo "<br>";
        echo "<strong>SKU:</strong> " . $furniture->getSKU();
        echo "<br>";
        echo "<strong>Name:</strong> " . $furniture->getName();
        echo "<br>";
        echo "<strong>Price:</strong> " . $furniture->getPrice() . " $";
        echo "<br>";
        echo "<strong>Dimensions:</strong> " . $furniture->getDimensions();
        echo "</div>";
    }
}

