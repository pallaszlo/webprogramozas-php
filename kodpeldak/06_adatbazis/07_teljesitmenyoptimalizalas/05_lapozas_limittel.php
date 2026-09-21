<?php

// =============================================================
// 6.23. LIMIT használata lapozáshoz
// =============================================================

// Előkészítés a futtatáshoz (nem része a könyvbeli kódpéldának)
require __DIR__ . '/../db.php';

$page = max(1, (int) ($_GET['page'] ?? 1));
$perPage = 20;
$offset = ($page - 1) * $perPage;

$stmt = $pdo->prepare("
    SELECT id, username, email
    FROM users
    ORDER BY created_at DESC
    LIMIT :limit OFFSET :offset
");

$stmt->bindValue('limit', $perPage, PDO::PARAM_INT);
$stmt->bindValue('offset', $offset, PDO::PARAM_INT);
$stmt->execute();

$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Kiegészítés (nem szerepel a könyvben): az aktuális oldal
echo "<p>{$page}. oldal</p>";
foreach ($users as $user) {
    echo htmlspecialchars($user['username']) . "<br>";
}
