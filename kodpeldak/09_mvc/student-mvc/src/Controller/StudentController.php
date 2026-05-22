<?php

namespace App\Controller;

use App\Core\BaseController;

class StudentController extends BaseController
{
    public function index(): void
    {
        $students = $this->model->getAll();
        $this->render('student/index', ['students' => $students]);
    }

    public function show(): void
    {
        $id      = (int)($_GET['id'] ?? 0);
        $student = $this->model->getById($id);

        if (!$student) {
            $this->redirect('index');
        }

        $this->render('student/show', ['student' => $student]);
    }

    public function create(): void
    {
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name  = trim($_POST['name']  ?? '');
            $email = trim($_POST['email'] ?? '');

            if ($name === '') {
                $errors[] = 'A név megadása kötelező.';
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Érvénytelen e-mail cím.';
            }

            if (empty($errors) && $this->model->create($name, $email)) {
                $this->redirect('index', 'Hallgató sikeresen létrehozva.');
            }
        }

        $this->render('student/create', ['errors' => $errors]);
    }

    public function edit(): void
    {
        $id      = (int)($_GET['id'] ?? 0);
        $student = $this->model->getById($id);

        if (!$student) {
            $this->redirect('index');
        }

        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name  = trim($_POST['name']  ?? '');
            $email = trim($_POST['email'] ?? '');

            if ($name === '') {
                $errors[] = 'A név megadása kötelező.';
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Érvénytelen e-mail cím.';
            }

            if (empty($errors) && $this->model->update($id, $name, $email)) {
                $this->redirect('index', 'Hallgató adatai frissítve.');
            }
        }

        $this->render('student/edit', [
            'student' => $student,
            'errors'  => $errors,
        ]);
    }

    public function delete(): void
    {
        $id = (int)($_GET['id'] ?? 0);

        if ($id > 0) {
            $this->model->delete($id);
        }

        $this->redirect('index', 'Hallgató törölve.');
    }
}
