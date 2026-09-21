<?php

// =============================================================
// 6.6. Egyszerű SELECT query()-vel
// =============================================================

// Előkészítés a futtatáshoz (nem része a könyvbeli kódpéldának)
require __DIR__ . '/../db.php';

try {
    $stmt = $pdo->query("SELECT * FROM users ORDER BY username ASC");

    while ($row = $stmt->fetch()) {
        echo htmlspecialchars($row['username']) . "<br>";
    }

} catch (PDOException $e) {
    error_log("Lekérdezési hiba: " . $e->getMessage());
    die("Lekérdezési hiba.");
}
