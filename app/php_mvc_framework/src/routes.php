<?php
use Codyngpriest\PhpMvcFramework\Router;
use Codyngpriest\PhpMvcFramework\Controllers\ProductController;
$router = new Router();

// Route for adding products
$router->addRoute('/app/product/add', ProductController::class, 'addProducts');

// Route for reading products
$router->addRoute('/app/product/read', ProductController::class, 'readProducts');

$router->addRoute('/app/product/delete-selected', ProductController::class, 'deleteSelectedProducts');


$router->addRoute('/', ProductController::class, 'index');

return $router;

