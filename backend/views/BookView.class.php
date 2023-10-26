<?php

class BookView {
    public function render(Book $book) {
        echo "<div>";
        echo "<strong>Product Type:</strong> Book";
        echo "<br>";
        echo "<strong>SKU:</strong> " . $book->getSKU();
        echo "<br>";
        echo "<strong>Name:</strong> " . $book->getName();
        echo "<br>";
        echo "<strong>Price:</strong> " . $book->getPrice() . " $";
        echo "<br>";
        echo "<strong>Weight:</strong> " . $book->getWeight() . " Kg";
        echo "</div>";
    }
}

