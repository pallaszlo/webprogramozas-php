<?php

// =============================================================
// 6.21. N+1 probléma megoldása: JOIN használata
// =============================================================

// Előkészítés a futtatáshoz (nem része a könyvbeli kódpéldának)
require __DIR__ . '/../db.php';

$stmt = $pdo->query("
    SELECT
        u.id AS user_id,
        u.email,
        o.id AS order_id,
        o.total,
        o.created_at
    FROM users u
    LEFT JOIN orders o ON u.id = o.user_id
    WHERE u.id <= 10
    ORDER BY u.id, o.created_at DESC
");

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

$users = [];
foreach ($results as $row) {
    $userId = $row['user_id'];

    if (!isset($users[$userId])) {
        $users[$userId] = [
            'email'  => $row['email'],
            'orders' => []
        ];
    }

    if ($row['order_id'] !== null) {
        $users[$userId]['orders'][] = [
            'id'    => $row['order_id'],
            'total' => $row['total']
        ];
    }
}

foreach ($users as $user) {
    echo "Felhasználó: " . $user['email'] .
         " - Rendelések: " . count($user['orders']) . "<br>";
}
