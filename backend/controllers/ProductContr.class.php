<?php

class ProductsContr {
    private $model;

    public function __construct(Product $model) {
        $this->model = $model;
    }

   public function createProductFromRequest() {
     // Check id the request is in JSON
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SERVER['CONTENT_TYPE']) && $_SERVER['CONTENT_TYPE'] === 'application/json') {
        // Retrieve the form data
        $data = json_decode(file_get_contents('php://input'), true);

        $sku = $data['sku'];
        $name = $data['name'];
        $price = $data['price'];
        $type = $data['type'];

        // Validate form data
        if (empty($sku) || empty($name) || empty($price) || empty($type)) {
            echo json_encode(['success' => false, 'message' => 'Please enter all required information']);
            return;
        } elseif (!$this->model->isSKUUnique($sku)) {
            echo json_encode(['success' => false, 'message' => 'Product with the same SKU already exists']);
            return;
        }

        // Create the product using the ProductFactory
        $product = ProductFactory::createProduct($data, $type);

        // Handle data validation and set product properties
        $product->setSKU($sku);
        $product->setName($name);
        $product->setPrice($price);

        // Save the product
        if ($product->save()) {
            echo json_encode(['success' => true, 'message' => 'Product saved successfully']);
            return;
        } else {
            // Log an error message for debugging
            error_log('Error saving the product');
            echo json_encode(['success' => false, 'message' => 'Error saving the product']);
            return;
        }
    }
}

       public function getProductBySKU($sku) {
        // Get the product by SKU using the model
        $product = $this->model->getProductBySKU($sku);

        if ($product) {
            $this->view->render($product);
        } else {
            echo json_encode(['success' => false, 'message' => 'Product not found']);
        }
    }

    public function deleteProduct($data) {
    if (isset($data['sku'])) {
        // Single product deletion
        $sku = $data['sku'];

        if ($this->model->deleteProductBySKU($sku)) {
            echo json_encode(['success' => true, 'message' => "Product with SKU '$sku' has been deleted."]);
        } else {
            // Log an error message for debugging
            error_log("Failed to delete product with SKU '$sku'.");
            echo json_encode(['success' => false, 'message' => "Failed to delete product with SKU '$sku'."]);
        }
    } elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
        // Mass delete operation
        if (isset($data['skus']) && is_array($data['skus'])) {
            $selectedSkus = $data['skus'];
            $messages = [];

            foreach ($selectedSkus as $sku) {
                if ($this->model->deleteProductBySKU($sku)) {
                    $messages[] = "Product with SKU '$sku' has been deleted.";
                } else {
                    // Log an error message for debugging
                    error_log("Failed to delete product with SKU '$sku'.");
                    $messages[] = "Failed to delete product with SKU '$sku'.";
                }
            }

            if (!empty($messages)) {
                echo json_encode(['success' => true, 'messages' => $messages]);
            } else {
                // Log an error message for debugging
                error_log('No products selected for deletion.');
                echo json_encode(['success' => false, 'message' => 'No products selected for deletion.']);
            }
        } else {
            // Log an error message for debugging
            error_log('No products selected for deletion.');
            echo json_encode(['success' => false, 'message' => 'No products selected for deletion.']);
        }
    } else {
        // Log an error message for debugging
        error_log('Invalid operation.');
        echo json_encode(['success' => false, 'message' => 'Invalid operation.']);
    }
}




    public function getProducts() {
    try {
        $conn = $this->openConnection(); // Implement openConnection and closeConnection in your class.

        // Query to retrieve complete product information
        $query = "SELECT p.*, d.size, b.weight, f.length, f.width, f.height
                  FROM products p
                  LEFT JOIN dvd_products d ON p.id = d.id
                  LEFT JOIN book_products b ON p.id = b.id
                  LEFT JOIN furniture_products f ON p.id = f.id";

        $stmt = $conn->prepare($query);
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $this->closeConnection($conn); // Close the connection

        return $products;
    } catch (PDOException $e) {
        // Handle database connection error
        error_log("Database connection error: " . $e->getMessage());
        http_response_code(500);
        echo "Oops! Something went wrong. Please try again later.";
    }
}
}

