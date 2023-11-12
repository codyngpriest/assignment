<?php
/**
 * Instance of a product
 * php version 8.1
 *
 * @category Custom_MVC
 * @package  MVC
 * @author   Vilho Banike <vilhopriestly@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @link     https://codyngpriest@github.com
 */

namespace Codyngpriest\PhpMvcFramework\Models;

use Codyngpriest\PhpMvcFramework\Database\DatabaseConnection;


/**
 * Contains props and methods specific to a Book product
 * php version 8.1
 *
 * @category Custom_MVC
 * @package  MVC
 * @author   Vilho Banike <vilhopriestly@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @link     https://codyngpriest@github.com
 */
class BookProduct extends Product
{
    private $_weight;
    /**
     * Inherits parent Product props and encapsulates a private prop
     *
     * @param $sku     A product stock keeping unit
     * @param $name    A product name
     * @param $price   A product price
     * @param $_weight A prop specific to Book 
     *
     * @return void
     */
    public function __construct($sku, $name, $price, $_weight)
    {
        parent::__construct($sku, $name, $price);
        $this->_weight = $_weight;
    }
    /**
     * Sets weight of a Book
     *
     * @param $_weight A private prop for Boook
     *
     * @return void
     */
    public function setWeight($_weight)
    {
        $this->_weight = $_weight;
    }
    /**
     * Gets weight of Book
     *
     * @return The weight of the Book
     */
    public function getWeight()
    {
        return $this->_weight;
    }
    /**
     * A save method to save a Book product to DB
     *
     * @param $productRepository A repository that implements save
     *
     * @return void
     */
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
    /**
     * A display method to display a Book
     *
     * @return void
     */
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
    /**
     * A mthod to get a Book product 
     *
     * @return Book
     */ 
    public function getProductType()
    {
        return "Book";
    }
}

