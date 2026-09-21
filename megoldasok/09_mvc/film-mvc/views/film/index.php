<?php use App\Helpers\ViewHelper; ?>

<h1>Filmkatalógus</h1>

<form class="search-form" method="GET" action="index.php">
    <input type="hidden" name="action" value="index">
    <input type="text" name="search"
           placeholder="Keresés cím vagy rendező alapján…"
           value="<?= ViewHelper::escape($search) ?>">
    <button type="submit" class="btn btn-secondary">Keresés</button>
    <?php if ($search !== ''): ?>
        <a class="btn btn-secondary" href="index.php?action=index">× Törlés</a>
    <?php endif; ?>
</form>

<?php if (!empty($search)): ?>
    <p><em>Keresési eredmények: „<?= ViewHelper::escape($search) ?>"</em></p>
<?php endif; ?>

<?php if (empty($films)): ?>
    <p>Nincs találat.</p>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <th>Cím</th>
                <th>Rendező</th>
                <th>Év</th>
                <th>Műfaj</th>
                <th>Műveletek</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($films as $f): ?>
            <tr>
                <td><?= ViewHelper::escape($f['title']) ?></td>
                <td><?= ViewHelper::escape($f['director']) ?></td>
                <td><?= ViewHelper::escape($f['year']) ?></td>
                <td><?= ViewHelper::escape($f['genre']) ?></td>
                <td>
                    <a class="btn btn-secondary"
                       href="<?= ViewHelper::url('show', ['id' => $f['id']]) ?>">
                        Részletek
                    </a>
                    <a class="btn btn-primary"
                       href="<?= ViewHelper::url('edit', ['id' => $f['id']]) ?>">
                        Szerkesztés
                    </a>
                    <a class="btn btn-danger"
                       href="<?= ViewHelper::url('delete', ['id' => $f['id']]) ?>"
                       onclick="return confirm('Biztosan törölni szeretnéd ezt a filmet?')">
                        Törlés
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<p><a class="btn btn-primary" href="index.php?action=create">+ Új film</a></p>
