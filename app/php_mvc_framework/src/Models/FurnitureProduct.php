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
 * Contains props and methods specific to a Furniture product
 * php version 8.1
 *
 * @category Custom_MVC
 * @package  MVC
 * @author   Vilho Banike <vilhopriestly@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @link     https://codyngpriest@github.com
 */
class FurnitureProduct extends Product
{
    private $_height;
    private $_width;
    private $_length;
    /**
     * Inherits parent Product props and encapsulates private props
     *
     * @param $sku     A product stock keeping unit
     * @param $name    A product name
     * @param $price   A product price
     * @param $_height A prop specific to Furniture
     * @param $_width  A prop specific to Furniture
     * @param $_length A prop specific to Furniture
     *
     * @return void
     */
    public function __construct($sku, $name, $price, $_height, $_width, $_length)
    {
        parent::__construct($sku, $name, $price);
        $this->_height = $_height;
        $this->_width = $_width;
        $this->_length = $_length;
    }
    /**
     * Sets private props of a furniture product
     *
     * @param $_height A private prop for Furniture
     * @param $_width  A private prop for Furniture
     * @param $_length A private prop for Furniture
     *
     * @return void
     */
    public function setDimensions($_height, $_width, $_length)
    {
        $this->_height = $_height;
        $this->_width = $_width;
        $this->_length = $_length;
    }
    /**
     * Gets dimensions of Furniture
     *
     * @return The dimensions of the Furniture
     */
    public function getDimensions()
    {
        return "Height: " . $this->_height . " cm,
        Width: " . $this->_width . " cm,
        Length: " . $this->_length . " cm";
    }
    /**
     * A save method to save a Furniture product to DB
     *
     * @param $productRepository A repository that implements save
     *
     * @return void
     */
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
    /**
     * A display method to display a Furniture
     *
     * @return void
     */
    public function display()
    {
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
    /**
     * A method to get a Furniture product
     *
     * @return Furniture
     */
    public function getProductType()
    {
        return "Furniture";
    }
}

