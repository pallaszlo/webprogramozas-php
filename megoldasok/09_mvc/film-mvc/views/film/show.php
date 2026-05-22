<?php use App\Helpers\ViewHelper; ?>

<h1><?= ViewHelper::escape($film['title']) ?></h1>

<table>
    <tr><th>ID</th>       <td><?= ViewHelper::escape($film['id']) ?></td></tr>
    <tr><th>Cím</th>      <td><?= ViewHelper::escape($film['title']) ?></td></tr>
    <tr><th>Rendező</th>  <td><?= ViewHelper::escape($film['director']) ?></td></tr>
    <tr><th>Év</th>       <td><?= ViewHelper::escape($film['year']) ?></td></tr>
    <tr><th>Műfaj</th>    <td><?= ViewHelper::escape($film['genre']) ?></td></tr>
    <tr><th>Hozzáadva</th><td><?= ViewHelper::escape($film['created_at']) ?></td></tr>
</table>

<p>
    <a class="btn btn-primary"
       href="<?= ViewHelper::url('edit', ['id' => $film['id']]) ?>">
        Szerkesztés
    </a>
    <a class="btn btn-secondary" href="index.php?action=index">Vissza</a>
</p>
