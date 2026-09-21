<?php

// =============================================================
// 6.7. SELECT előkészített utasítás használatával
// =============================================================

// Előkészítés a futtatáshoz (nem része a könyvbeli kódpéldának)
require __DIR__ . '/../db.php';

try {
    $stmt = $pdo->prepare("
        SELECT id, username, email, city
        FROM users
        WHERE age > :age AND city = :city
    ");

    $stmt->execute([
        'age'  => 18,
        'city' => 'Budapest'
    ]);

    while ($row = $stmt->fetch()) {
        echo htmlspecialchars($row['username']) . " - ";
        echo htmlspecialchars($row['city']) . "<br>";
    }

} catch (PDOException $e) {
    error_log("Lekérdezési hiba: " . $e->getMessage());
    die("Lekérdezési hiba.");
}
