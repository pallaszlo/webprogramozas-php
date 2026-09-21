<?php

require __DIR__ . '/../vendor/autoload.php';

define('BASE_PATH', dirname(__DIR__));

use App\Core\Container;
use App\Core\Database;
use App\Core\Router;
use App\Model\Film;
use App\Model\Genre;
use App\Controller\FilmController;
use App\Controller\GenreController;

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

// 4. feladat: a Genre modell és kontrollere
$container->set(Genre::class, fn(Container $c)
    => new Genre($c->get('database')));

$container->set(GenreController::class, fn(Container $c)
    => new GenreController($c->get(Genre::class)));

// --- Router inicializálása ---
$router = new Router($container);

$router->add('index',  FilmController::class, 'index');
$router->add('show',   FilmController::class, 'show');
$router->add('create', FilmController::class, 'create');
$router->add('edit',   FilmController::class, 'edit');
$router->add('delete', FilmController::class, 'delete');

$router->add('genres',       GenreController::class, 'index');
$router->add('genre_create', GenreController::class, 'create');

// --- A kérés továbbítása a kontrollerhez ---
$router->dispatch('index');
