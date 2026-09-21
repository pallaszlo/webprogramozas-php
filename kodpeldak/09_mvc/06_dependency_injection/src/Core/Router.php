<?php

// =============================================================
// 9.23. Router osztály
// =============================================================

namespace App\Core;

class Router
{
    private array $routes = [];
    private Container $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function add(string $action,
                       string $controllerClass,
                       string $method): void
    {
        $this->routes[$action] = [
            'controller' => $controllerClass,
            'method'     => $method,
        ];
    }

    public function dispatch(?string $action = null,
                            string $defaultAction = 'index'): void
    {
        $action = $action ?? $_GET['action'] ?? $defaultAction;

        if (!isset($this->routes[$action])) {
            http_response_code(404);
            echo "A kért oldal nem található.";
            exit;
        }

        $route = $this->routes[$action];
        $controllerClass = $route['controller'];
        $controller = $this->container->get($controllerClass);
        $method = $route['method'];
        $controller->$method();
    }
}
