<?php

namespace App\Core;

/** Az URL action paraméterét a megfelelő kontroller metódusához rendeli. */
class Router
{
    private array $routes = [];

    public function __construct(private Container $container) {}

    /**
     * Útvonal regisztrálása: az action neve, a kontroller osztálya és a meghívandó metódus.
     */
    public function add(string $action,
                        string $controllerClass,
                        string $method): void
    {
        $this->routes[$action] = [
            'controller' => $controllerClass,
            'method'     => $method,
        ];
    }

    /**
     * Az action paraméter alapján meghívja a kontroller metódusát. Ismeretlen útvonalnál
     * 404-es választ ad.
     */
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
