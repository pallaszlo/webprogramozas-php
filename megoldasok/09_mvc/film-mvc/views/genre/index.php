<?php use App\Helpers\ViewHelper; ?>

<h1>Műfajok</h1>

<table>
    <thead>
        <tr><th>ID</th><th>Név</th></tr>
    </thead>
    <tbody>
        <?php foreach ($genres as $g): ?>
        <tr>
            <td><?= ViewHelper::escape($g['id']) ?></td>
            <td><?= ViewHelper::escape($g['name']) ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<p><a class="btn btn-primary" href="<?= ViewHelper::url('genre_create') ?>">+ Új műfaj</a></p>
