<?php

// =============================================================
// 9.4. StudentController osztály
// =============================================================

namespace App\Controller;

use App\Model\Student;

class StudentController
{
    public function __construct(private Student $studentModel) {}

    public function index(): void
    {
        $students = $this->studentModel->getAll();
        include __DIR__ . '/../../views/student/index.php';
    }

    public function show(): void
    {
        $id = (int)($_GET['id'] ?? 0);
        $student = $this->studentModel->getById($id);

        if (!$student) {
            header('Location: index.php?action=index');
            exit;
        }

        include __DIR__ . '/../../views/student/show.php';
    }

    public function create(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';

            if ($this->studentModel->create($name, $email)) {
                header('Location: index.php?action=index&msg=created');
                exit;
            }
        }

        include __DIR__ . '/../../views/student/create.php';
    }

    // edit() és delete() metódusok hasonlóan...
}
