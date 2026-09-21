<?php /* Kiegészítés (nem szerepel a könyvben): a hallgató adatai */ ?>
<?php use App\Helpers\ViewHelper; ?>

<h1><?= ViewHelper::escape($student['name']) ?></h1>
<table>
    <tr><th>E-mail</th><td><?= ViewHelper::escape($student['email']) ?></td></tr>
    <tr><th>Létrehozva</th><td><?= ViewHelper::escape($student['created_at']) ?></td></tr>
</table>
<p><a class="btn btn-secondary" href="<?= ViewHelper::url('index') ?>">Vissza</a></p>
