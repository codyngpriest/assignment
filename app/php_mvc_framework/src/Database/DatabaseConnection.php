<?php
/**
 * Handles DB connection for Mysql DB
 * php version 8.1
 *
 * @category Custom_MVC
 * @package  MVC
 * @author   Vilho Banike <vilhopriestly@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @link     https://codyngpriest@github.com
 */

namespace Codyngpriest\PhpMvcFramework\Database;

use PDO;
use PDOException;


/**
 * Handles DB connection for Mysql DB
 * php version 8.1
 *
 * @category Custom_MVC
 * @package  MVC
 * @author   Vilho Banike <vilhopriestly@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @link     https://codyngpriest@github.com
 */
class DatabaseConnection
{
    private $_host;
    private $_db;
    private $_username;
    private $_password;
    private $_conn;
    private static $_instance = null;
    /**
     * Handles props for DB configuration.
     * php version 8.1
     *
     * @category Custom_MVC
     * @package  MVC
     * @author   Vilho Banike <vilhopriestly@gmail.com>
     * @license  http://opensource.org/licenses/gpl-license.php  GNU Public License
     * @link     https://codyngpriest@github.com
     */
    private function __construct()
    {
        $this->_host = DatabaseConfig::DB_HOST;
        $this->_db = DatabaseConfig::DB_NAME;
        $this->_username = DatabaseConfig::DB_USER;
        $this->_password = DatabaseConfig::DB_PASSWORD;
    }
    /**
     * Handles an instance for DB connection
     * php version 8.1
     *
     * @category Custom_MVC
     * @package  MVC
     * @author   Vilho Banike <vilhopriestly@gmail.com>
     * @license  http://opensource.org/licenses/gpl-license.php  GNU Public License
     * @link     https://codyngpriest@github.com
     *
     * @return An instance of the connection
     */
    public static function getInstance()
    {
        if (self::$_instance === null) {
            self::$_instance = new DatabaseConnection();
        }
        return self::$_instance;
    }
     /**
      * Handles database open connection for DB connection
      * php version 8.1
      *
      * @category Custom_MVC
      * @package  MVC
      * @author   Vilho Banike <vilhopriestly@gmail.com>
      * @license  http://opensource.org/licenses/gpl-license.php
      * GNU Public License
      * @link     https://codyngpriest@github.com
      *
      * @return The open connection
      */
    public function openConnection()
    {
        try {
            $this->conn = new PDO(
                "mysql:host={$this->_host};dbname={$this->_db}",
                $this->_username,
                $this->_password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->exec("set names utf8");

            // Database connection successful, log it
            error_log("Connected to the database successfully");

            return $this->conn; // Return the database connection
        } catch (PDOException $e) {
            // Handle the error gracefully
            error_log("Database connection error: " . $e->getMessage());
            die("Oops! Something went wrong. Please try again later.");
        }
    }
     /**
      * Handles an instance for DB closing.
      * php version 8.1
      *
      * @category Custom_MVC
      * @package  MVC
      * @author   Vilho Banike <vilhopriestly@gmail.com>
      * @license  http://opensource.org/licenses/gpl-license.php  GNU
      * Public License
      * @link     https://codyngpriest@github.com
      *
      * @return The closed connection
      */
    public function closeConnection()
    {
        $this->conn = null;
    }
     /**
      * Handles an instance for DB opening
      * php version 8.1
      *
      * @category Custom_MVC
      * @package  MVC
      * @author   Vilho Banike <vilhopriestly@gmail.com>
      * @license  http://opensource.org/licenses/gpl-license.php  GNU
      * Public License
      * @link     https://codyngpriest@github.com
      *
      * @return The open connection
      */
    public function getConnection()
    {
        return $this->conn;
    }
}
