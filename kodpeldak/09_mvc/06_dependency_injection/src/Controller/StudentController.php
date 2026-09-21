<?php

// =============================================================
// 9.13. StudentController osztály
// =============================================================

namespace App\Controller;

use App\Core\BaseController;

class StudentController extends BaseController
{
    public function index(): void
    {
        $students = $this->model->getAll();
        $this->render('student/index', [
            'students' => $students,
            'message'  => $_GET['message'] ?? null,
        ]);
    }

    public function create(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';

            if ($this->model->create($name, $email)) {
                $this->redirect('index', 'created');
                return;
            }
        }

        $this->render('student/create');
    }

    // Kiegészítés (nem szerepel a könyvben): a 9.9. kódpélda "show" útvonalához
    public function show(): void
    {
        $student = $this->model->getById((int)($_GET['id'] ?? 0));

        if (!$student) {
            $this->redirect('index');
        }

        $this->render('student/show', ['student' => $student]);
    }
    // Kiegészítés (nem szerepel a könyvben): szerkesztés és törlés
    public function edit(): void
    {
        $student = $this->model->getById((int)($_GET['id'] ?? 0));

        if (!$student) {
            $this->redirect('index');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';

            if ($this->model->update($student['id'], $name, $email)) {
                $this->redirect('index', 'updated');
                return;
            }

            $student = array_merge($student, ['name' => $name, 'email' => $email]);
        }

        $this->render('student/edit', ['student' => $student]);
    }

    public function delete(): void
    {
        $this->model->delete((int)($_GET['id'] ?? 0));
        $this->redirect('index', 'deleted');
    }
}
