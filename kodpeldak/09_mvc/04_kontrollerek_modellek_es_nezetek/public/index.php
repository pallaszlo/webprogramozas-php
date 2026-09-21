<?php

// =============================================================
// 9.9. Front Controller Routerrel (index.php)
// =============================================================

require __DIR__ . '/../vendor/autoload.php';

use App\Core\Database;
use App\Core\Router;
use App\Model\Student;
use App\Controller\StudentController;

$db = (new Database())->getConnection();
$router = new Router($db);

// Student routes
$router->add('index', StudentController::class,
             'index', Student::class);
$router->add('show', StudentController::class,
             'show', Student::class);
$router->add('create', StudentController::class,
             'create', Student::class);
// ... további routes

// Route végrehajtás
$router->dispatch();
