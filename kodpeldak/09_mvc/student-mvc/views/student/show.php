<?php use App\Helpers\ViewHelper; ?>

<h1>Hallgató adatai</h1>

<table>
    <tr><th>ID</th><td><?= ViewHelper::escape($student['id']) ?></td></tr>
    <tr><th>Név</th><td><?= ViewHelper::escape($student['name']) ?></td></tr>
    <tr><th>E-mail</th><td><?= ViewHelper::escape($student['email']) ?></td></tr>
    <tr><th>Létrehozva</th><td><?= ViewHelper::escape($student['created_at']) ?></td></tr>
</table>

<p>
    <a class="btn btn-primary"
       href="<?= ViewHelper::url('edit', ['id' => $student['id']]) ?>">
        Szerkesztés
    </a>
    <a class="btn btn-secondary" href="index.php?action=index">Vissza</a>
</p>
