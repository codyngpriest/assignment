<?php
namespace Codyngpriest\PhpMvcFramework;

use Codyngpriest\PhpMvcFramework\Controller;
use ReflectionMethod;

class Router {
    protected $routes = [];

    public function addRoute($route, $controller, $action) {
        $this->routes[$route] = ['controller' => $controller, 'action' => $action];
    }

    public function dispatch($uri, $method) {
        // Debug: Log the URI and request method
        error_log("Before routing: URI = $uri, Method = $method");

        foreach ($this->routes as $routePattern => $routeInfo) {
            error_log("Checking route pattern: $routePattern");

            // Check if the current route pattern matches the requested URI
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
                 // $controller->$action(...$params);
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

    // Helper function to check if a route pattern matches the requested URI
    protected function matchRoute($routePattern, $uri) {
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

 protected function extractRouteParameters($routePattern, $uri) {
    // Extract route parameters enclosed in curly braces {}
    preg_match_all('/{([^}]+)}/', $routePattern, $matches);

    // Extract values for route parameters from the URI
    $paramValues = [];
    foreach ($matches[1] as $paramName) {
      //$paramPattern = "/$paramName\/([^\/]+|$)/";
      $paramPattern = "/$paramName\/([^\/]+)/";
        if (preg_match($paramPattern, $uri, $paramMatches)) {
            // Use the correct array key to access the captured value
            $paramValues[$paramName] = $paramMatches[1];
        }
    }

    // Debug: Log the extracted parameters
    error_log("Extracted parameters: " . print_r($paramValues, true));

    return $paramValues;
}


}

