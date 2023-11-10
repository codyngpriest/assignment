<?php
namespace Codyngpriest\PhpMvcFramework\Controllers;

// Enable CORS
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, DELETE");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

$requestUri = $_SERVER['REQUEST_URI'];

if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && $requestUri === '/app/product/delete-selected/{id}') {
    header("Access-Control-Allow-Origin: http://localhost:5173");
    header("Access-Control-Allow-Methods: DELETE");
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    http_response_code(200);
    exit;
}


use Codyngpriest\PhpMvcFramework\Controller;
use Codyngpriest\PhpMvcFramework\Models\ProductFactory;
use Codyngpriest\PhpMvcFramework\Models\ProductRepository;
use Codyngpriest\PhpMvcFramework\Models\Product;
use Codyngpriest\PhpMvcFramework\Database\DatabaseConnection;
use PDO;

class ProductController extends Controller
{    
    protected $uri;
    public function setCurrentUri($uri)
    {
        $this->uri = $uri;
    }
    protected $productRepository;

    public function __construct()
    {
        $dbConnection = DatabaseConnection::getInstance();
        $this->productRepository = new ProductRepository($dbConnection);
    }

    public function addProducts()
    {
    // Check if the request method is POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        error_log(print_r($_POST, true));

        // Retrieve and validate the JSON data
        $postData = file_get_contents("php://input");
        $data = json_decode($postData, true);

        // Check if the JSON data was successfully decoded
        if ($data === null) {
            // Handle JSON decoding error
            echo json_encode(['success' => false, 'message' => 'Invalid JSON data']);
            return;
        }

        // Additional attributes specific to each product type
        $attributes = $this->getProductAttributes($data);
        if (empty($data['sku']) || empty($data['name']) || empty($data['price']) || empty($data['type']) || count($attributes) === 0) {
            // Handle validation errors
            // Return an error response to the client
            echo json_encode(['success' => false, 'message' => 'Invalid data']);
            return;
        }

        // Use the ProductFactory to create the product
        $product = ProductFactory::createProduct($data,  $this->productRepository);

        if (!$product) {
            // Handle unknown product type
            echo json_encode(['success' => false, 'message' => 'Unknown product type']);
            return;
        }

        // Initialize the database connection
        $conn = DatabaseConnection::getInstance()->openConnection();

        // Save the product
        if ($product->save($this->productRepository)) {
            // Product saved successfully
            DatabaseConnection::getInstance()->closeConnection();
            echo json_encode(['success' => true, 'message' => 'Product added successfully']);
        } else {
            // Handle database error
            DatabaseConnection::getInstance()->closeConnection();
            echo json_encode(['success' => false, 'message' => 'Error saving product']);
        }
    } else {
        // Handle invalid request method (not POST)
        echo json_encode(['success' => false, 'message' => 'Invalid request']);
    }
}

    // Helper function to retrieve additional attributes based on the product type
      private function getProductAttributes($data)
    {
    $type = $data['type'];

    // Define a map of product types to their corresponding attributes
    $attributeMap = [
        'Book' => ['weight'],
        'DVD' => ['size'],
        'Furniture' => ['height', 'width', 'length'],
    ];

    // Check if the product type exists in the map
    if (array_key_exists($type, $attributeMap)) {
        // Extract attributes based on the product type
        return array_map(function ($attribute) use ($data) {
            return $data[$attribute];
        }, $attributeMap[$type]);
    }

    return [];
}


    // Helper function to retrieve a POST parameter safely
private function getPostParam($key)
{
        return isset($_POST[$key]) ? $_POST[$key] : null;
}

public function readProducts()
{
        try {
            $conn = DatabaseConnection::getInstance()->openConnection();

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
            DatabaseConnection::getInstance()->closeConnection($conn);
        } catch (PDOException $e) {
            // Handle database connection error
            error_log("Database connection error: " . $e->getMessage());
            http_response_code(500);
            echo "Oops! Something went wrong. Please try again later.";
        }
}

    /**
     * @Route(method="DELETE")
     */
  // Update the deleteSelectedProducts method in ProductController.php
public function deleteSelectedProducts($params)
{
    try {
        // Assuming 'ids' is the parameter name containing an array of product IDs
        $ids = isset($params['ids']) ? $params['ids'] : [];

        // Check if $ids is an array before iterating
        if (!is_array($ids)) {
            throw new \Exception("Invalid 'ids' parameter.");
        }

        // Set the current URI in the controller
        $this->setCurrentUri('/app/product/delete-selected');

        foreach ($ids as $id) {
            $product = $this->productRepository->getProductById($id);

            if (!$product) {
                throw new \Exception("Product with ID '$id' not found.");
            }

            if (!$this->productRepository->deleteProductById($id)) {
                throw new \Exception("Failed to delete product with ID '$id'.");
            }
        }

        echo "Selected products have been deleted successfully.";
    } catch (\Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}

}

