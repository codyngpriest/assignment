<?php
/**
 * Defines a route for the custom MVC.
 * php version 8.1
 *
 * @category Custom_MVC
 * @package  MVC
 * @author   Vilho Banike <vilhopriestly@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @link     https://codyngpriest@github.com
 */

use Codyngpriest\PhpMvcFramework\Router;
use Codyngpriest\PhpMvcFramework\Controllers\ProductController;
use Codyngpriest\PhpMvcFramework\Controllers\DefaultController;

// Instantiate a new Router
$router = new Router();

// Route for default controller
$router->addRoute('/', DefaultController::class, 'index');

// Route for adding products
$router->addRoute('/app/product/add', ProductController::class, 'addProducts');

// Route for reading products
$router->addRoute('/app/product/read', ProductController::class, 'readProducts');

// Route for deleting a single product
$router->addRoute(
    '/app/product/delete/{id}',
    ProductController::class,
    'deleteProduct'
);

// Route for deleting selected products
$router->addRoute(
    '/app/product/delete-selected',
    ProductController::class,
    'deleteSelectedProducts'
);

return $router;

