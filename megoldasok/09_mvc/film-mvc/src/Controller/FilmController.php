<?php

namespace App\Controller;

use App\Core\BaseController;

class FilmController extends BaseController
{
    public function index(): void
    {
        $search = trim($_GET['search'] ?? '');

        if ($search !== '') {
            $films = $this->model->search($search);
        } else {
            $films = $this->model->getAll();
        }

        $this->render('film/index', [
            'films'  => $films,
            'search' => $search,
        ]);
    }

    public function show(): void
    {
        $id   = (int)($_GET['id'] ?? 0);
        $film = $this->model->getById($id);

        if (!$film) {
            $this->redirect('index');
        }

        $this->render('film/show', ['film' => $film]);
    }

    public function create(): void
    {
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title    = trim($_POST['title']    ?? '');
            $director = trim($_POST['director'] ?? '');
            $year     = (int)($_POST['year']    ?? 0);
            $genre    = trim($_POST['genre']    ?? '');

            if ($title === '') {
                $errors[] = 'A film címe kötelező.';
            }
            if ($director === '') {
                $errors[] = 'A rendező neve kötelező.';
            }
            if ($year < 1888 || $year > 2100) {
                $errors[] = 'Érvénytelen megjelenési év (1888–2100).';
            }
            if ($genre === '') {
                $errors[] = 'A műfaj megadása kötelező.';
            }

            if (empty($errors) &&
                $this->model->create($title, $director, $year, $genre)) {
                $this->redirect('index', 'Film sikeresen hozzáadva.');
            }
        }

        $this->render('film/create', ['errors' => $errors]);
    }

    public function edit(): void
    {
        $id   = (int)($_GET['id'] ?? 0);
        $film = $this->model->getById($id);

        if (!$film) {
            $this->redirect('index');
        }

        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title    = trim($_POST['title']    ?? '');
            $director = trim($_POST['director'] ?? '');
            $year     = (int)($_POST['year']    ?? 0);
            $genre    = trim($_POST['genre']    ?? '');

            if ($title === '') {
                $errors[] = 'A film címe kötelező.';
            }
            if ($director === '') {
                $errors[] = 'A rendező neve kötelező.';
            }
            if ($year < 1888 || $year > 2100) {
                $errors[] = 'Érvénytelen megjelenési év (1888–2100).';
            }
            if ($genre === '') {
                $errors[] = 'A műfaj megadása kötelező.';
            }

            if (empty($errors) &&
                $this->model->update($id, $title, $director, $year, $genre)) {
                $this->redirect('index', 'Film adatai frissítve.');
            }
        }

        $this->render('film/edit', [
            'film'   => $film,
            'errors' => $errors,
        ]);
    }

    public function delete(): void
    {
        $id = (int)($_GET['id'] ?? 0);

        if ($id > 0) {
            $this->model->delete($id);
        }

        $this->redirect('index', 'Film törölve.');
    }
}
