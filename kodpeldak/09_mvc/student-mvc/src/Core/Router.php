<?php

namespace App\Core;

class Router
{
    private array $routes = [];

    public function __construct(private Container $container) {}

    public function add(string $action,
                        string $controllerClass,
                        string $method): void
    {
        $this->routes[$action] = [
            'controller' => $controllerClass,
            'method'     => $method,
        ];
    }

    public function dispatch(string $action = 'index'): void
    {
        $action = $_GET['action'] ?? $action;

        if (!isset($this->routes[$action])) {
            http_response_code(404);
            echo "A kért oldal nem található.";
            exit;
        }

        $route      = $this->routes[$action];
        $controller = $this->container->get($route['controller']);
        $method     = $route['method'];
        $controller->$method();
    }
}
