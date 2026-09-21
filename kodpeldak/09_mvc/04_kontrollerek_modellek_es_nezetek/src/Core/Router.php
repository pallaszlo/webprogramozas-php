<?php

// =============================================================
// 9.8. Router osztály
// =============================================================

namespace App\Core;

use PDO;

class Router
{
    private array $routes = [];
    private PDO $database;

    public function __construct(PDO $database)
    {
        $this->database = $database;
    }

    public function add(string $action,
                       string $controllerClass,
                       string $method,
                       string $modelClass): void
    {
        $this->routes[$action] = [
            'controller' => $controllerClass,
            'method' => $method,
            'model' => $modelClass
        ];
    }

    public function dispatch(?string $action = null): void
    {
        $action = $action ?? $_GET['action'] ?? 'index';

        if (!isset($this->routes[$action])) {
            $this->redirect404();
            return;
        }

        $route = $this->routes[$action];

        $model = new $route['model']($this->database);

        $controller = new $route['controller']($model);

        $method = $route['method'];
        $controller->$method();
    }

    private function redirect404(): void
    {
        http_response_code(404);
        echo "A kért oldal nem található.";
        exit;
    }
}
