<?php
/**
 * Handles routing for the custom MVC.
 * php version 8.1
 *
 * @category Custom_MVC
 * @package  MVC
 * @author   Vilho Banike <vilhopriestly@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @link     https://codyngpriest@github.com
 */
namespace Codyngpriest\PhpMvcFramework;
/**
 * Handles routing for the custom MVC.
 * php version 8.1
 *
 * @category Custom_MVC
 * @package  MVC
 * @author   Vilho Banike <vilhopriestly@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @link     https://codyngpriest@github.com
 */
class Controller
{
    /**
     * Finds and renders a component
     *
     * @param $view A view to render
     * @param $data A valid data to accept
     *
     * @return void
     */
    protected function render($view, $data = [])
    {
        extract($data);

        include "Views/$view.php";
    }
  
}
