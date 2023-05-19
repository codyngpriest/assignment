<?php
require_once 'config/database.php';
require_once 'class/Product.php';

$products = Product::getAllProducts();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Product Management</title>
    <!-- Include your CSS and JS files if needed -->
</head>
<body>
    <h1>Product Management</h1>
    <a href="add.php">Add Product</a>
    <form id="mass_delete_form" action="delete.php" method="post">
        <table>
            <tr>
                <th>SKU</th>
                <th>Name</th>
                <th>Price</th>
                <th>Delete</th>
            </tr>
            <?php foreach ($products as $product) { ?>
                <tr>
                    <td><?php echo $product['sku']; ?></td>
                    <td><?php echo $product['name']; ?></td>
                    <td><?php echo $product['price']; ?></td>
                    <td>
                        <input class="delete-checkbox" type="checkbox" name="selected_products[]" value="<?php echo $product['id']; ?>">
                    </td>
                </tr>
            <?php } ?>
        </table>
        <input type="submit" name="delete_selected" value="Delete Selected">
    </form>

    <script>
        document.getElementById('mass_delete_form').addEventListener('submit', function (event) {
            var checkboxes = document.querySelectorAll('.delete-checkbox');
            var checkedCount = 0;

            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].checked) {
                    checkedCount++;
                }
            }

            if (checkedCount === 0) {
                alert('Please select at least one product to delete.');
                event.preventDefault();
            } else if (!confirm('Are you sure you want to delete the selected products?')) {
                event.preventDefault();
            }
        });
    </script>
</body>
</html>

