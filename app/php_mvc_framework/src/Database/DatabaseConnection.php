<?php
namespace Codyngpriest\PhpMvcFramework\Database;

use PDO;
use PDOException;

class DatabaseConnection {
    private $host;
    private $db;
    private $username;
    private $password;
    private $conn;
    private static $instance = null;

    private function __construct() {
        $this->host = DatabaseConfig::DB_HOST;
        $this->db = DatabaseConfig::DB_NAME;
        $this->username = DatabaseConfig::DB_USER;
        $this->password = DatabaseConfig::DB_PASSWORD;
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new DatabaseConnection();
        }
        return self::$instance;
    }

    public function openConnection() {
        try {
            $this->conn = new PDO("mysql:host={$this->host};dbname={$this->db}", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->exec("set names utf8");

            // Database connection successful, log it
            error_log("Connected to the database successfully");

            return $this->conn; // Return the database connection
        } catch (PDOException $e) {
            // Handle the error gracefully, e.g., log it and display a user-friendly message.
            error_log("Database connection error: " . $e->getMessage());
            die("Oops! Something went wrong. Please try again later.");
        }
    }

    public function closeConnection() {
        $this->conn = null;
    }

    public function getConnection() {
        return $this->conn;
    }
}
