<?php
require_once '../01_db.php';
require_once 'ProductRepository.php';

$repo     = new ProductRepository($pdo);
$messages = [];

// Létrehozás
try {
    $newId      = $repo->create('Teszt termék', 99.90, 5, 1);
    $messages[] = "create(): azonosító = $newId";
} catch (PDOException $e) {
    $messages[] = "create() hiba: " . $e->getMessage();
}

// Lekérdezés ID alapján
$product = $repo->findById(1);
if ($product) {
    $messages[] = "findById(1): " . $product['name'] . " – " . number_format((float)$product['price'], 2) . " RON";
} else {
    $messages[] = "findById(1): nem található";
}

// Frissítés
$updated    = $repo->update(1, 'Laptop Pro', 1599.99, 8);
$messages[] = "update(1): " . ($updated ? 'sikeres' : 'nem volt változás');

// Összes termék száma
$all        = $repo->findAll();
$messages[] = "findAll(): " . count($all) . " termék";

// Törlés (az imént létrehozott tesztterméket töröljük)
if (isset($newId)) {
    $deleted    = $repo->delete($newId);
    $messages[] = "delete($newId): " . ($deleted ? 'törölve' : 'nem található');
}
?><!DOCTYPE html>
<html lang="hu">
<head><meta charset="UTF-8"><title>ProductRepository</title></head>
<body>

<h1>ProductRepository – demo</h1>

<h2>Műveletek naplója</h2>
<ul>
    <?php foreach ($messages as $msg): ?>
        <li><?= htmlspecialchars($msg) ?></li>
    <?php endforeach; ?>
</ul>

<h2>Aktuális termékek (findAll)</h2>
<table border="1" cellpadding="6">
    <tr><th>ID</th><th>Név</th><th>Ár (RON)</th><th>Készlet</th></tr>
    <?php foreach ($repo->findAll() as $p): ?>
    <tr>
        <td><?= (int)$p['id'] ?></td>
        <td><?= htmlspecialchars($p['name']) ?></td>
        <td><?= number_format((float)$p['price'], 2) ?></td>
        <td><?= (int)$p['stock'] ?></td>
    </tr>
    <?php endforeach; ?>
</table>

</body>
</html>
