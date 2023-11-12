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
 * Contains props and methods specific to a DVD product
 * php version 8.1
 *
 * @category Custom_MVC
 * @package  MVC
 * @author   Vilho Banike <vilhopriestly@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @link     https://codyngpriest@github.com
 */
class DVDProduct extends Product
{
    private $_size;
    /**
     * Inherits parent Product props and encapsulates a private prop
     *
     * @param $sku   A product stock keeping unit
     * @param $name  A product name
     * @param $price A product price
     * @param $_size A prop specific to DVD
     *
     * @return void
     */
    public function __construct($sku, $name, $price, $_size)
    {
        parent::__construct($sku, $name, $price);
        $this->_size = $_size;
    }
    /**
     * Sets size of a DVD
     *
     * @param $_size A private prop for DVD
     *
     * @return void
     */
    public function setSize($_size)
    {
        $this->_size = $_size;
    }
    /**
     * Gets size of DVD
     *
     * @return The size of the DVD
     */
    public function getSize()
    {
        return $this->_size;
    }
    /**
     * A save method to save a DVD product to DB
     *
     * @param $productRepository A repository that implements save
     *
     * @return void
     */
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
    /**
     * A display method to display a DVD
     *
     * @return void
     */
    public function display()
    {
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
    /**
     * A method to get a DVD product
     *
     * @return DVD
     */
    public function getProductType()
    {
        return "DVD";
    }
}

