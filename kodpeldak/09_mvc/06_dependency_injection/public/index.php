<?php

// =============================================================
// 9.22. Front Controller DI Containerrel (index.php)
// =============================================================

require __DIR__ . '/../vendor/autoload.php';

use App\Core\Container;
use App\Core\Database;
use App\Core\Router;
use App\Model\Student;
use App\Controller\StudentController;

// Container inicializálása
$container = new Container();

// Database service
$container->set('database', function () {
    return (new Database())->getConnection();
});

// Model definíciók
$container->set(Student::class, function (Container $c) {
    return new Student($c->get('database'));
});

// Controller definíciók
$container->set(StudentController::class, function (Container $c) {
    return new StudentController($c->get(Student::class));
});

// Router inicializálása Containerrel
$router = new Router($container);

// Routes regisztrálása
$router->add('index', StudentController::class, 'index');
// ... további routes
// Kiegészítés (nem szerepel a könyvben): a további útvonalak
$router->add('show', StudentController::class, 'show');
$router->add('create', StudentController::class, 'create');
$router->add('edit', StudentController::class, 'edit');
$router->add('delete', StudentController::class, 'delete');

// Request dispatch
$action = $_GET['action'] ?? 'index';
$router->dispatch($action, 'index');
