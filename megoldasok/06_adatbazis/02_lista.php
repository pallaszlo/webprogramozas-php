<?php
require_once '01_db.php';

$search   = trim($_GET['name'] ?? '');

if ($search !== '') {
    $stmt = $pdo->prepare("
        SELECT * FROM products
        WHERE name LIKE :name
        ORDER BY name ASC
    ");
    $stmt->execute(['name' => '%' . $search . '%']);
} else {
    $stmt = $pdo->query("SELECT * FROM products ORDER BY name ASC");
}

$products = $stmt->fetchAll();
?><!DOCTYPE html>
<html lang="hu">
<head><meta charset="UTF-8"><title>Termékek listája</title></head>
<body>

<h1>Termékek listája</h1>

<form method="GET">
    <label>Keresés névben:
        <input type="text" name="name" value="<?= htmlspecialchars($search) ?>">
    </label>
    <button type="submit">Szűrés</button>
    <?php if ($search): ?>
        <a href="?">Visszaállítás</a>
    <?php endif; ?>
</form>

<?php if (empty($products)): ?>
    <p>Nincs találat.</p>
<?php else: ?>
    <table border="1" cellpadding="6">
        <tr><th>ID</th><th>Név</th><th>Ár (RON)</th><th>Készlet</th><th>Műveletek</th></tr>
        <?php foreach ($products as $p): ?>
        <tr>
            <td><?= (int)$p['id'] ?></td>
            <td><?= htmlspecialchars($p['name']) ?></td>
            <td><?= number_format((float)$p['price'], 2) ?></td>
            <td><?= (int)$p['stock'] ?></td>
            <td>
                <a href="04_termek_szerkesztes.php?id=<?= (int)$p['id'] ?>">Szerkesztés</a> |
                <a href="05_termek_torles.php?id=<?= (int)$p['id'] ?>">Törlés</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <p><strong>Összesen: <?= count($products) ?> termék</strong></p>
<?php endif; ?>

<p><a href="03_termek_felvetel.php">+ Új termék felvétele</a></p>

</body>
</html>
