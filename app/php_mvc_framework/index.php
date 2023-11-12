<?php
/** 
 * Main Entry for the custom MVC.
 * php version 8.1
 *
 * @category Custom_MVC
 * @package  MVC
 * @author   Vilho Banike <vilhopriestly@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @link     https://codyngpriest@github.com
 */

require 'vendor/autoload.php';

$uri = $_SERVER['REQUEST_URI'];

$router = include 'src/routes.php';
$router->dispatch($uri, $_SERVER['REQUEST_METHOD']);

