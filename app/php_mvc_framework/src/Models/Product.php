<?php
/**
 * Main business logic
 * php version 8.1
 *
 * @category Custom_MVC
 * @package  MVC
 * @author   Vilho Banike <vilhopriestly@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @link     https://codyngpriest@github.com
 */

namespace Codyngpriest\PhpMvcFramework\Models;

/**
 * Contains generic product props and methods for concrete classes
 * php version 8.1
 *
 * @category Custom_MVC
 * @package  MVC
 * @author   Vilho Banike <vilhopriestly@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @link     https://codyngpriest@github.com
 */
abstract class Product
{
    protected $id;
    protected $sku;
    protected $name;
    protected $price;


    /**
     * Defines generic product props
     *
     * @param $sku   A product stock keeping unit
     * @param $name  A product name
     * @param $price A product price
     *
     * @return void
     */
    public function __construct($sku, $name, $price)
    {
        $this->sku = $sku;
        $this->name = $name;
        $this->price = $price;
    }
    /**
     * Sets product sku
     *
     * @param $sku A product sku
     *
     * @return void
     */
    public function setSKU($sku)
    {
        $this->sku = $sku;
    }
     /**
      * Gets product sku
      *
      * @return The product sku
      */
    public function getSKU()
    {
        return $this->sku;
    }

    /**
     * Sets product name
     *
     * @param $name A product name
     *
     * @return void
     */
    public function setName($name)
    {
        $this->name = $name;
    }
     /**
      * Gets product name
      *
      * @return The product name
      */
    public function getName()
    {
        return $this->name;
    }
     /**
      * Sets product price
      *
      * @param $price A product price
      *
      * @return void
      */
    public function setPrice($price)
    {
        $this->price = $price;
    }
     /**
      * Gets product price
      *
      * @return The product price
      */
    public function getPrice()
    {
        return $this->price;
    }
     /**
      * Sets product id
      *
      * @param $id A product id
      *
      * @return void
      */
    public function setId($id)
    {
        $this->id = $id;
    }
     /**
      * Gets product id
      *
      * @return The product id
      */
    public function getID()
    {
        return $this->id;
    }
    /**
     * Contract save to be implemented in concrete clases
     *
     * @param $productRepository A repository that implements save
     *
     * @return void
     */
    abstract public function save(ProductRepository $productRepository);
    /**
     * Contract display to be implemented in each concrete class
     *
     * @return void
     */
    abstract public function display();
    /**
     * Contract getProductType to be implemented in each concrete class
     *
     * @return void
     */ 
    abstract public function getProductType();
}

