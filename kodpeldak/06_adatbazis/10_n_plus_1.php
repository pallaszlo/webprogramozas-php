<?php
require_once '00_db.php';

// Orders tábla létrehozása és feltöltése, ha szükséges
$pdo->exec("
    CREATE TABLE IF NOT EXISTS orders (
        id         INT AUTO_INCREMENT PRIMARY KEY,
        user_id    INT NOT NULL,
        product    VARCHAR(100) NOT NULL,
        total      DECIMAL(10,2) NOT NULL,
        created_at DATETIME NOT NULL DEFAULT NOW(),
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    )
");

if ((int)$pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn() === 0) {
    $pdo->exec("
        INSERT INTO orders (user_id, product, total) VALUES
            (1, 'Laptop',       1499.99),
            (1, 'Egér',           29.90),
            (2, 'Billentyűzet', 149.00),
            (3, 'Monitor',      599.00),
            (3, 'Kábel',         19.90)
    ");
}

// --- N+1 query: hibás megközelítés ---
$nPlusOneResults = [];
$users = $pdo->query("SELECT id, username FROM users")->fetchAll();
foreach ($users as $user) {
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM orders WHERE user_id = :uid");
    $stmt->execute(['uid' => $user['id']]);
    $nPlusOneResults[] = [
        'username'    => $user['username'],
        'order_count' => (int)$stmt->fetchColumn(),
    ];
}
$nPlusOneQueries = count($users) + 1;

// --- JOIN: helyes megközelítés ---
$joinResults = $pdo->query("
    SELECT u.username, COUNT(o.id) AS order_count
    FROM users u
    LEFT JOIN orders o ON u.id = o.user_id
    GROUP BY u.id, u.username
    ORDER BY u.username
")->fetchAll();
?><!DOCTYPE html>
<html lang="hu">
<head><meta charset="UTF-8"><title>N+1 query probléma</title></head>
<body>

<h1>N+1 query probléma és megoldása</h1>

<h2>Hibás megközelítés (N+1 query)</h2>
<p>Végrehajtott lekérdezések száma: <strong><?= $nPlusOneQueries ?></strong></p>
<ul>
    <?php foreach ($nPlusOneResults as $row): ?>
        <li><?= htmlspecialchars($row['username']) ?>: <?= $row['order_count'] ?> rendelés</li>
    <?php endforeach; ?>
</ul>

<h2>Helyes megközelítés (egyetlen JOIN)</h2>
<p>Végrehajtott lekérdezések száma: <strong>1</strong></p>
<ul>
    <?php foreach ($joinResults as $row): ?>
        <li><?= htmlspecialchars($row['username']) ?>: <?= (int)$row['order_count'] ?> rendelés</li>
    <?php endforeach; ?>
</ul>

</body>
</html>
