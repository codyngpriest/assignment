<?php
/**
 * Handles routing for the custom MVC. php version 8.1
 *
 * @category Custom_MVC
 * @package  MVC
 * @author   Vilho Banike <vilhopriestly@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @link     https://codyngpriest@github.com
 */

namespace Codyngpriest\PhpMvcFramework;

use Codyngpriest\PhpMvcFramework\Controller;
use ReflectionMethod;


/**
 * Class Router
 *
 * Uses a simple path matching to match routes.
 *
 * @category Custom_MVC
 * @package  MVC
 * @author   Vilho Banike <vilhopriestly@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @link     https://codyngpriest@github.com
 */
class Router
{
    protected $routes = [];

    /**
     * Adds a route to the router.
     *
     * @param string $route      The route pattern to add.
     * @param string $controller The controller class name.
     * @param string $action     The action method name.
     *
     * @return str
     * @throws an error If no route is found
     */
    public function addRoute($route, $controller, $action)
    {
        $this->routes[$route] = ['controller' => $controller, 'action' => $action];
    }

    /**
     * Dispatches the request to the appropriate controller and action.
     *
     * @param string $uri    The URI of the request.
     * @param string $method The HTTP method of the request.
     *
     * @return void
     */
    public function dispatch($uri, $method)
    {
        // Logs the URI and method for debugging
        error_log("Before routing: URI = $uri, Method = $method");

        foreach ($this->routes as $routePattern => $routeInfo) {
            error_log("Checking route pattern: $routePattern");

            // Checks if the current route pattern matches the requested URI
            if ($this->matchRoute($routePattern, $uri)) {
                $controller = $routeInfo['controller'];
                $action = $routeInfo['action'];

                // Extract route parameters
                $params = $this->extractRouteParameters($routePattern, $uri);
                // Debug: Log route matching and parameter extraction
                error_log("Matched route pattern: $routePattern");
                error_log("Route parameters: " . implode(', ', $params));

                // Create a new instance of the controller
                $controller = new $controller();

                // Set the current URI in the controller
                $controller->setCurrentUri($uri);

                // Check if the action expects parameters using Reflection
                $reflectionMethod = new ReflectionMethod($controller, $action);
                $parameterCount = $reflectionMethod->getNumberOfParameters();

                if ($parameterCount > 0) {
                    // The action expects parameters, pass them
                    $controller->$action($params);
                } else {
                    // The action doesn't expect parameters, call it without any
                    $controller->$action();
                }

                return;
            }
        }

        // Debug: Log when no route is found
        error_log("No route found for URI: $uri");

        throw new \Exception("No route found for URI: $uri");
    }

    /**
     * Helper function to check if a route pattern matches the requested URI.
     *
     * @param string $routePattern The route pattern to match.
     * @param string $uri          The URI to extract parameters from.
     *
     * @return bool
     */
    protected function matchRoute($routePattern, $uri)
    {
        // Debug: Log the route pattern and URI for debugging
        error_log("Matching route pattern: $routePattern with URI: $uri");
        // Convert route pattern to a regular expression
        $pattern = preg_replace('/{([^}]+)}/', '([^/]+)', $routePattern);
        $pattern = str_replace('/', '\/', $pattern);
        $pattern = '/^' . $pattern . '$/';

        // Debug: Log the resulting regular expression pattern
        error_log("Regular expression pattern: $pattern");

        return preg_match($pattern, $uri);
    }

    /**
     * Extract route parameters from the URI based on the route pattern.
     *
     * @param string $routePattern The route pattern to match.
     * @param string $uri          The URI to extract parameters from.
     *
     * @return array
     */
    protected function extractRouteParameters($routePattern, $uri)
    {
        // Extract route parameters enclosed in curly braces {}
        preg_match_all('/{([^}]+)}/', $routePattern, $matches);

        // Extract values for route parameters from the URI
        $paramValues = [];
        foreach ($matches[1] as $paramName) {
            // Regular expression pattern to match the URI segment
            $paramPattern = "/$paramName\/([^\/]+)/";
            if (preg_match($paramPattern, $uri, $paramMatches)) {
                // The correct array key to access the captured value
                $paramValues[$paramName] = $paramMatches[1];
            }
        }

        // Debug: Log the extracted parameters
        error_log("Extracted parameters: " . print_r($paramValues, true));

        return $paramValues;
    }

}

