<?php
require_once 'config.php';

class DB {
    private static $instance = null;
    private $host;
    private $db;
    private $username;
    private $password;
    public $conn;

    public function __construct() {
        $this->host = DB_HOST;
        $this->db = DB_NAME;
        $this->username = DB_USER;
        $this->password = DB_PASSWORD;
    }

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new DB();
        }
        return self::$instance;
    }

    public function getConnection() {
        if (!$this->conn) {
            try {
                $this->conn = new PDO("mysql:host={$this->host};dbname={$this->db}", $this->username, $this->password);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->conn->exec("set names utf8");
            } catch (PDOException $exception) {
                // Log or handle the error gracefully
                error_log("Database connection error: " . $exception->getMessage());
                // Display a user-friendly message
                die("Oops! Something went wrong. Please try again later.");
            }
        }
        return $this->conn;
    }
}
?>

