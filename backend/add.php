<?php
require_once 'config/database.php';
require_once 'class/Product.php';
require_once 'class/DVD.php';
require_once 'class/Book.php';
require_once 'class/Furniture.php';

header('Access-Control-Allow-Origin: http://localhost:5173');
header('Access-Control-Allow-Headers: Content-Type');
header('Cache-Control: no-store');

$notification = '';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the form data
    $data = json_decode(file_get_contents('php://input'), true);

    $sku = $data['sku'];
    $name = $data['name'];
    $price = $data['price'];
    $type = $data['type'];

    // Validate form data
    if (empty($sku) || empty($name) || empty($price) || empty($type)) {
        $notification = "Please enter all required information";
    } elseif (!Product::isSKUUnique($sku)) {
        $notification = "Product with the same SKU already exists";
    } else {
        // Create an instance of the appropriate product type based on the selected product type
        switch ($type) {
            case 'DVD':
                $product = new DVD($sku, $name, $price);
                $product->setSize($data['size']);
                break;
            case 'Book':
                $product = new Book($sku, $name, $price);
                $product->setWeight($data['weight']);
                break;
            case 'Furniture':
                $product = new Furniture($sku, $name, $price, $data['length'], $data['width'], $data['height']);
                break;
            default:
                $notification = "Invalid product type";
                break;
        }

        if (isset($product)) {
            // Establish a database connection
            $conn = getConnection();

            // Save the product
            if ($product->save($conn)) {
                // Send a JSON response indicating success
                echo json_encode(['success' => true]);
                exit;
            } else {
                $notification = "Error saving the product";
            }

            // Close the database connection
            closeConnection($conn);
        }
    }
}

// Function to establish a database connection
function getConnection()
{
    $servername = "localhost";
    $username = "codyngpriest";
    $password = "@Yttrgh1";
    $dbname = "product_database";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}

// Function to close the database connection
function closeConnection($conn)
{
    $conn->close();
}
?>

