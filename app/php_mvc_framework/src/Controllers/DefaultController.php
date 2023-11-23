<?php
/**
 * Default controller for the root path
 * php version 8.1
 *
 * @category Custom_MVC
 * @package  MVC
 * @author   Vilho Banike <vilhopriestly@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @link     https://codyngpriest@github.com
 */

namespace Codyngpriest\PhpMvcFramework\Controllers;

use Codyngpriest\PhpMvcFramework\Controller;

/**
 * DefaultController class for handling default requests.
 */
class DefaultController extends Controller
{
    protected $uri;
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
     * Default action for handling requests to the root URL.
     */
    public function index()
    {
        // Your default action logic goes here
        echo "Welcome to the default page!";
    }
}

