<?php
require_once 'config/database.php';
require_once 'class/Product.php';
require_once 'class/DVD.php';
require_once 'class/Book.php';
require_once 'class/Furniture.php';

$notification = '';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the form data
    $sku = $_POST['sku'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $type = $_POST['productType'];

    // Validate form data
    if (empty($sku) || empty($name) || empty($price) || empty($type)) {
        $notification = "Please enter all required information";
    } elseif (Product::getProductBySKU($sku)) {
        $notification = "Product with the same SKU already exists";
    } else {
        // Create an instance of the appropriate product type based on the selected product type
        switch ($type) {
            case 'DVD':
                $product = new DVD($sku, $name, $price);
                $product->setSize($_POST['size']);
                break;
            case 'Book':
                $product = new Book($sku, $name, $price);
                $product->setWeight($_POST['weight']);
                break;
            case 'Furniture':
                $product = new Furniture($sku, $name, $price);
                $product->setDimensions($_POST['height'], $_POST['width'], $_POST['length']);
                break;
            default:
                $notification = "Invalid product type";
                break;
        }

        if (isset($product)) {
            // Save the product
            if ($product->save()) {
                // Redirect back to the product list page
                header('Location: index.php');
                exit;
            } else {
                $notification = "Error saving the product";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Product</title>
    <!-- Include your CSS files if needed -->
    <style>
        .type-specific-fields {
            display: none;
        }
    </style>
    <script>
        window.onload = function() {
            // Get references to the type-specific attribute fields
            var sizeField = document.getElementById('sizeField');
            var weightField = document.getElementById('weightField');
            var dimensionsField = document.getElementById('dimensionsField');

            // Get the product type dropdown
            var productTypeDropdown = document.getElementById('productType');

            // Add an event listener to detect changes in the product type dropdown
            productTypeDropdown.addEventListener('change', function() {
                // Hide all type-specific attribute fields
                sizeField.style.display = 'none';
                weightField.style.display = 'none';
                dimensionsField.style.display = 'none';

                // Show the selected type-specific attribute field
                var selectedType = productTypeDropdown.value;
                if (selectedType === 'DVD') {
                    sizeField.style.display = 'block';
                } else if (selectedType === 'Book') {
                    weightField.style.display = 'block';
                } else if (selectedType === 'Furniture') {
                    dimensionsField.style.display = 'block';
                }
            });
        };
    </script>
</head>
<body>
    <h1>Add Product</h1>
    <?php if (!empty($notification)) : ?>
        <div>
            <?php echo $notification; ?>
        </div>
    <?php endif; ?>
    <form id="product_form" action="" method="post">
        <div>
            <label for="sku">SKU:</label>
            <input type="text" id="sku" name="sku" required placeholder="Please enter SKU">
        </div>
        <div>
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required placeholder="Please enter name">
        </div>
        <div>
            <label for="price">Price:</label>
            <input type="number" id="price" step="0.01" name="price" required placeholder="Please enter price">
        </div>
        <div>
            <label for="productType">Product Type:</label>
            <select id="productType" name="productType" required>
                <option value="DVD">DVD</option>
                <option value="Book">Book</option>
                <option value="Furniture">Furniture</option>
            </select>
        </div>
        <div id="typeSpecificAttributes">
            <!-- DVD-specific attribute -->
            <div class="type-specific-fields" id="sizeField">
                <label for="size">Size (MB):</label>
                <input type="number" step="0.01" id="size" name="size" placeholder="Please enter size">
            </div>
            <!-- Book-specific attribute -->
            <div class="type-specific-fields" id="weightField">
                <label for="weight">Weight (Kg):</label>
                <input type="number" step="0.01" id="weight" name="weight" placeholder="Please enter weight">
            </div>
            <!-- Furniture-specific attributes -->
            <div class="type-specific-fields" id="dimensionsField">
                <div>
                    <label for="height">Height (CM):</label>
                    <input type="number" step="0.01" id="height" name="height" placeholder="Please enter height">
                </div>
                <div>
                    <label for="width">Width (CM):</label>
                    <input type="number" step="0.01" id="width" name="width" placeholder="Please enter width">
                </div>
                <div>
                    <label for="length">Length (CM):</label>
                    <input type="number" step="0.01" id="length" name="length" placeholder="Please enter length">
                </div>
            </div>
        </div>
        <div>
            <input type="submit" value="Save">
            <input type="button" value="Cancel" onclick="window.location.href = 'index.php';">
        </div>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && empty($notification)) {
        // Redirect to the Product List page after successful save
        echo "<script>window.location.href = 'index.php';</script>";
    }
    ?>
</body>
</html>

