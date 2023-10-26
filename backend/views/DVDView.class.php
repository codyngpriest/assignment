<?php

class DVDView {
    public function render(DVD $dvd) {
        echo "<div>";
        echo "<strong>Product Type:</strong> " . $dvd->getProductType();
        echo "<br>";
        echo "<strong>SKU:</strong> " . $dvd->getSKU();
        echo "<br>";
        echo "<strong>Name:</strong> " . $dvd->getName();
        echo "<br>";
        echo "<strong>Price:</strong> " . $dvd->getPrice() . " $";
        echo "<br>";
        echo "<strong>Size:</strong> " . $dvd->getSize() . " MB";
        echo "</div>";
    }
}

