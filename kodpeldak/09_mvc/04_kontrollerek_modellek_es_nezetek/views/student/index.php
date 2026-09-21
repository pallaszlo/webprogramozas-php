<?php /* Kiegészítés (nem szerepel a könyvben): a hallgatók listája a layouttal */ ?>
<?php use App\Helpers\ViewHelper; ?>

<h1>Hallgatók</h1>
<p><a class="btn btn-primary" href="<?= ViewHelper::url('create') ?>">Új hallgató</a></p>

<table>
    <thead>
        <tr><th>Név</th><th>E-mail</th><th>Műveletek</th></tr>
    </thead>
    <tbody>
        <?php foreach ($students as $row): ?>
        <tr>
            <td><?= ViewHelper::escape($row['name']) ?></td>
            <td><?= ViewHelper::escape($row['email']) ?></td>
            <td>
                <a href="<?= ViewHelper::url('show', ['id' => $row['id']]) ?>">Megtekintés</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
