<?php
require_once __DIR__ . '/config/database.php';

// Enable CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');


try {
    $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query to retrieve complete product information
    $query = "SELECT p.*, d.size, b.weight, f.length, f.width, f.height
              FROM products p
              LEFT JOIN dvd_products d ON p.id = d.id
              LEFT JOIN book_products b ON p.id = b.id
              LEFT JOIN furniture_products f ON p.id = f.id";

    $stmt = $conn->prepare($query);
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Send the response as JSON
    header('Content-Type: application/json');
    echo json_encode($products);
} catch (PDOException $e) {
    // Handle database connection error
    error_log("Database connection error: " . $e->getMessage());
    http_response_code(500);
    echo "Oops! Something went wrong. Please try again later.";
}
?>

