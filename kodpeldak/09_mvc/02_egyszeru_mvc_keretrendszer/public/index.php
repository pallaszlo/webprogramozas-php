<?php

// =============================================================
// 9.5. Front Controller (index.php)
// =============================================================

require __DIR__ . '/../vendor/autoload.php';

use App\Core\Database;
use App\Model\Student;
use App\Controller\StudentController;

$db = (new Database())->getConnection();
$action = $_GET['action'] ?? 'index';

$studentModel = new Student($db);
$controller = new StudentController($studentModel);

match ($action) {
    'index'  => $controller->index(),
    'show'   => $controller->show(),
    'create' => $controller->create(),
    'edit'   => $controller->edit(),
    'delete' => $controller->delete(),
    default  => header('Location: index.php?action=index'),
};
exit;
