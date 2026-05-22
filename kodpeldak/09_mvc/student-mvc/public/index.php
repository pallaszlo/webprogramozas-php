<?php

require __DIR__ . '/../vendor/autoload.php';

define('BASE_PATH', dirname(__DIR__));

use App\Core\Container;
use App\Core\Database;
use App\Core\Router;
use App\Model\Student;
use App\Controller\StudentController;

// --- Container inicializálása ---
$container = new Container();

$container->set('database', fn() => (new Database(
    host:   'localhost',
    dbname: 'student_mvc',
    user:   'root',
    pass:   '',
))->getConnection());

$container->set(Student::class, fn(Container $c)
    => new Student($c->get('database')));

$container->set(StudentController::class, fn(Container $c)
    => new StudentController($c->get(Student::class)));

// --- Router inicializálása ---
$router = new Router($container);

$router->add('index',  StudentController::class, 'index');
$router->add('show',   StudentController::class, 'show');
$router->add('create', StudentController::class, 'create');
$router->add('edit',   StudentController::class, 'edit');
$router->add('delete', StudentController::class, 'delete');

// --- Flash message kezelése ---
$message = $_GET['message'] ?? '';

// --- Dispatch ---
$router->dispatch('index');
