<?php

namespace App;

class Router
{
    private array $routes = [];

    /**
     * Add a GET route
     */
    public function get(string $path, string $controller, string $method): void
    {
        $this->addRoute('GET', $path, $controller, $method);
    }

    /**
     * Add a POST route
     */
    public function post(string $path, string $controller, string $method): void
    {
        $this->addRoute('POST', $path, $controller, $method);
    }

    /**
     * Add a route for any method
     */
    public function any(string $path, string $controller, string $method): void
    {
        $this->addRoute('ANY', $path, $controller, $method);
    }

    /**
     * Add route to collection
     */
    private function addRoute(string $httpMethod, string $path, string $controller, string $method): void
    {
        $this->routes[] = [
            'method' => $httpMethod,
            'path' => $path,
            'controller' => $controller,
            'action' => $method
        ];
    }

    /**
     * Dispatch the request
     */
    public function dispatch(): void
    {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        
        // Remove trailing slash
        $requestUri = rtrim($requestUri, '/');
        if (empty($requestUri)) {
            $requestUri = '/';
        }

        foreach ($this->routes as $route) {
            if (($route['method'] === $requestMethod || $route['method'] === 'ANY') 
                && $this->matchPath($route['path'], $requestUri)) {
                
                $controllerClass = $route['controller'];
                $action = $route['action'];

                if (!class_exists($controllerClass)) {
                    $this->error404();
                    return;
                }

                $controller = new $controllerClass();
                
                if (!method_exists($controller, $action)) {
                    $this->error404();
                    return;
                }

                $controller->$action();
                return;
            }
        }

        $this->error404();
    }

    /**
     * Match path with wildcards
     */
    private function matchPath(string $routePath, string $requestUri): bool
    {
        // Simple exact match for now
        return $routePath === $requestUri;
    }

    /**
     * Show 404 error
     */
    private function error404(): void
    {
        http_response_code(404);
        require __DIR__ . '/../view/errors/404.php';
        exit;
    }
}
