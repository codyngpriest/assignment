<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Form</title>
</head>
<body>
    <h1>Product Form</h1>

    <!-- Add Product Form -->
    <h2>Add Product</h2>
    <form action="/app/product/add" method="post">
        <label for="type">Product Type:</label>
        <select name="type" id="type" required>
            <option value="Book">Book</option>
            <option value="DVD">DVD</option>
            <option value="Furniture">Furniture</option>
        </select><br>

        <label for="sku">SKU:</label>
        <input type="text" name="sku" id="sku" required><br>

        <label for="name">Name:</label>
        <input type="text" name="name" id="name" required><br>

        <label for="price">Price:</label>
        <input type="number" name="price" id="price" required><br>

        <!-- Additional attributes based on product type -->
        <div id="attributes"></div>

        <button type="submit">Add Product</button>
    </form>


    <!-- Delete Selected Products Form -->
    <h2>Delete Selected Products</h2>
    <form method="post" action="/app/product/delete-selected">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>SKU</th>
                <!-- Add more columns as needed -->
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <!-- Display products with checkboxes for deletion -->
            <?php
            // Fetch products from the database (you may need to modify this based on your implementation)
            $products = $this->productRepository->getAllProducts();

            foreach ($products as $product) {
                echo '<tr>';
                echo '<td>' . $product['id'] . '</td>';
                echo '<td>' . $product['name'] . '</td>';
                echo '<td>' . $product['sku'] . '</td>';
                // Add more columns as needed
                echo '<td><input type="checkbox" name="selectedProducts[]" value="' . $product['id'] . '"></td>';
                echo '</tr>';
            }
            ?>
        </tbody>
    </table>

    <button type="submit">Delete Selected</button>
</form>

    <script>
        // JavaScript to dynamically update attributes based on product type
        document.getElementById('type').addEventListener('change', function() {
            const type = this.value;
            const attributesDiv = document.getElementById('attributes');

            // Clear previous attributes
            attributesDiv.innerHTML = '';

            // Add attributes based on selected product type
            switch (type) {
                case 'Book':
                    attributesDiv.innerHTML = `
                        <label for="weight">Weight:</label>
                        <input type="text" name="weight" id="weight" required><br>
                    `;
                    break;
                case 'DVD':
                    attributesDiv.innerHTML = `
                        <label for="size">Size:</label>
                        <input type="text" name="size" id="size" required><br>
                    `;
                    break;
                case 'Furniture':
                    attributesDiv.innerHTML = `
                        <label for="height">Height:</label>
                        <input type="text" name="height" id="height" required><br>
                        <label for="width">Width:</label>
                        <input type="text" name="width" id="width" required><br>
                        <label for="length">Length:</label>
                        <input type="text" name="length" id="length" required><br>
                    `;
                    break;
                default:
                    break;
            }
        });
    </script>
</body>
</html>

