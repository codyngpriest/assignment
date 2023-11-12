<?php
/**
 * Controller for all product controlls and methods
 * php version 8.1
 *
 * @category Custom_MVC
 * @package  MVC
 * @author   Vilho Banike <vilhopriestly@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @link     https://codyngpriest@github.com
 */
namespace Codyngpriest\PhpMvcFramework\Controllers;

// Enable CORS
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, DELETE");
header(
    "Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept"
);

use Codyngpriest\PhpMvcFramework\Controller;
use Codyngpriest\PhpMvcFramework\Models\ProductFactory;
use Codyngpriest\PhpMvcFramework\Models\ProductRepository;
use Codyngpriest\PhpMvcFramework\Models\Product;
use Codyngpriest\PhpMvcFramework\Database\DatabaseConnection;
use PDO;


/**
 * Controller Main entry point for all product operations
 * php version 8.1
 *
 * @category Custom_MVC
 * @package  MVC
 * @author   Vilho Banike <vilhopriestly@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @link     https://codyngpriest@github.com
 */
class ProductController extends Controller
{
    protected $uri;
    protected $productRepository;
    /**
     * Sets the current uri for routing
     *
     * @param $uri The uri to dispatch
     *
     * @return void
     */
    public function setCurrentUri($uri)
    {
        $this->uri = $uri;
    }
    /**
     * Initiates a DB connection
     *
     * @return void
     */
    public function __construct()
    {
        $dbConnection = DatabaseConnection::getInstance();
        $this->productRepository = new ProductRepository($dbConnection);
    }
     /**
      * Adds a new product to the database
      *
      * @return void
      */
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
                echo json_encode(
                    [
                    'success' => false,
                    'message' => 'Invalid JSON data'
                    ]
                );
                return;
            }

            // Additional attributes specific to each product type
            $attributes = $this->_getProductAttributes($data);
            if (empty($data['sku']) || empty($data['name']) 
                || empty($data['price']) || empty($data['type']) 
                || count($attributes) === 0
            ) {
                // Handle validation errors
                // Return an error response to the client
                echo json_encode(
                    [
                    'success' => false, 'message' => 'Invalid data'
                    ]
                );
                return;
            }

            // Use the ProductFactory to create the product
            $product = ProductFactory::createProduct(
                $data,
                $this->productRepository
            );

            if (!$product) {
                // Handle unknown product type
                echo json_encode(
                    [
                    'success' => false,
                    'message' => 'Unknown product type'
                    ]
                );
                return;
            }

            // Initialize the database connection
            $conn = DatabaseConnection::getInstance()->openConnection();

            // Save the product
            if ($product->save($this->productRepository)) {
                // Product saved successfully
                DatabaseConnection::getInstance()->closeConnection();
                echo json_encode(
                    [
                    'success' => true,
                    'message' => 'Product added successfully'
                    ]
                );
            } else {
                // Handle database error
                DatabaseConnection::getInstance()->closeConnection();
                echo json_encode(
                    [
                    'success' => false,
                    'message' => 'Error saving product'
                    ]
                );
            }
        } else {
            // Handle invalid request method (not POST)
            echo json_encode(
                [
                'success' => false,
                'message' => 'Invalid request'
                ]
            );
        }
    }
     /**
      * Retrieves attributes based on product type
      *
      * @param $data The the product type
      *
      * @return An array
      */
    private function _getProductAttributes($data)
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
            return array_map(
                function ($attribute) use ($data) {
                    return $data[$attribute];
                }, $attributeMap[$type]
            );
        }

        return [];
    }
    /**
     * Reads products from the DB
     *
     * @return A list of products
     */
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
     * Deletes a single product from the database by ID
     *
     * @param array $params The route parameters, including 'id'
     *
     * @return void
     */
    public function deleteProduct($params)
    {
        $input = file_get_contents('php://input');
        $data = json_decode($input, true);

        // Log or inspect $data to check if the 'ids' parameter is 
        // correctly received.
        error_log("Request Payload: " . print_r($data, true));
        try {
              $id = isset($params['id']) ? $params['id'] : null;

              // Check if the ID is provided
            if ($id === null) {
                throw new \Exception("Missing 'id' parameter.");
            }

            // Attempt to delete the product
            $deleted = $this->productRepository->deleteProductById($id);

            // Check if deletion was successful
            if (!$deleted) {
                throw new \Exception(
                    "Product with ID '$id' not found or failed to delete."
                );
            }

            // Send a JSON response
            header('Content-Type: application/json');
            echo json_encode(
                [
                'message' => "Product with ID $id has been deleted successfully."
                ]
            );
        } catch (\Exception $e) {
            // Log the exception
             http_response_code(400); // Bad Request
             header('Content-Type: application/json');
             echo json_encode(['error' => $e->getMessage()]);
        }
    }


    /**
     * Deletes selected products from the database
     *
     * @param array $params The route parameters, including 'ids'
     *
     * @return void
     */
    public function deleteSelectedProducts($params)
    {
        $input = file_get_contents('php://input');
        $data = json_decode($input, true);

          // Log inspect $data to check if the 'ids' parameter
          // is correctly received.
        error_log("Request Payload: " . print_r($data, true));
        try {
              $ids = isset($data['ids']) ? $data['ids'] : [];

              // Check if $ids is an array before iterating
            if (!is_array($ids)) {
                throw new \Exception("Invalid 'ids' parameter.");
            }

            foreach ($ids as $id) {
                // Attempt to delete the product
                $deleted = $this->productRepository->deleteProductById($id);

                // Check if deletion was successful
                if (!$deleted) {
                    throw new \Exception(
                        "Product with ID '$id' not found or failed to delete."
                    );
                }
            }

            // Send a JSON response
            header('Content-Type: application/json');
            echo json_encode(
                [
                'message' => "Selected products have been deleted successfully."
                ]
            );
        } catch (\Exception $e) {
            // Log the exception 
             http_response_code(400); // Bad Request
             header('Content-Type: application/json');
             echo json_encode(['error' => $e->getMessage()]);
        }
    }

}

