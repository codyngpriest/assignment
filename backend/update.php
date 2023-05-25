<?php
require_once '../config/database.php';

// Retrieve the updated product information from the request
$data = json_decode(file_get_contents("php://input"), true);

try {
    $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Update the product in the database
    $query = "UPDATE products SET name = :name, price = :price WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':name', $data['name']);
    $stmt->bindParam(':price', $data['price']);
    $stmt->bindParam(':id', $data['id']);
    $stmt->execute();

    // Send a success response
    http_response_code(200);
    echo "Product updated successfully";
} catch (PDOException $e) {
    // Handle database connection or update error
    error_log("Database error: " . $e->getMessage());
    http_response_code(500);
    echo "Oops! Something went wrong. Please try again later.";
}
?>

