<?php

namespace App\Controller;

use App\Core\BaseController;

/** 4. feladat: a műfajok listázását és felvételét kezelő kontroller. */
class GenreController extends BaseController
{
    /** A műfajok listája. */
    public function index(): void
    {
        $this->render('genre/index', [
            'genres'  => $this->model->getAll(),
            'message' => $_GET['message'] ?? null,
        ]);
    }

    /** Új műfaj felvétele. Üres vagy már létező név esetén hibaüzenetet ad. */
    public function create(): void
    {
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');

            if ($name === '') {
                $errors[] = 'A műfaj neve kötelező.';
            } elseif ($this->model->existsByName($name)) {
                $errors[] = 'Ez a műfaj már szerepel a listában.';
            }

            if (empty($errors) && $this->model->create($name)) {
                $this->redirect('genres', 'Műfaj hozzáadva.');
            }
        }

        $this->render('genre/create', ['errors' => $errors]);
    }
}
