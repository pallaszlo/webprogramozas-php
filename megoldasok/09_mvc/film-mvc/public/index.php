<?php

require __DIR__ . '/../vendor/autoload.php';

define('BASE_PATH', dirname(__DIR__));

use App\Core\Container;
use App\Core\Database;
use App\Core\Router;
use App\Model\Film;
use App\Controller\FilmController;

// --- Container inicializálása ---
$container = new Container();

$container->set('database', fn() => (new Database(
    host:   'localhost',
    dbname: 'film_mvc',
    user:   'root',
    pass:   '',
))->getConnection());

$container->set(Film::class, fn(Container $c)
    => new Film($c->get('database')));

$container->set(FilmController::class, fn(Container $c)
    => new FilmController($c->get(Film::class)));

// --- Router inicializálása ---
$router = new Router($container);

$router->add('index',  FilmController::class, 'index');
$router->add('show',   FilmController::class, 'show');
$router->add('create', FilmController::class, 'create');
$router->add('edit',   FilmController::class, 'edit');
$router->add('delete', FilmController::class, 'delete');

// --- Flash message kezelése ---
$message = $_GET['message'] ?? '';

// --- Dispatch ---
$router->dispatch('index');
