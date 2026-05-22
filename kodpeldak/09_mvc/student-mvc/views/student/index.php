<?php use App\Helpers\ViewHelper; ?>

<h1>Hallgatók</h1>

<?php if (empty($students)): ?>
    <p>Nincsenek hallgatók az adatbázisban.</p>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <th>Név</th>
                <th>E-mail</th>
                <th>Műveletek</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($students as $s): ?>
            <tr>
                <td><?= ViewHelper::escape($s['name']) ?></td>
                <td><?= ViewHelper::escape($s['email']) ?></td>
                <td>
                    <a class="btn btn-secondary"
                       href="<?= ViewHelper::url('show', ['id' => $s['id']]) ?>">
                        Megtekintés
                    </a>
                    <a class="btn btn-primary"
                       href="<?= ViewHelper::url('edit', ['id' => $s['id']]) ?>">
                        Szerkesztés
                    </a>
                    <a class="btn btn-danger"
                       href="<?= ViewHelper::url('delete', ['id' => $s['id']]) ?>"
                       onclick="return confirm('Biztosan törölni szeretnéd?')">
                        Törlés
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<p><a class="btn btn-primary" href="index.php?action=create">+ Új hallgató</a></p>
