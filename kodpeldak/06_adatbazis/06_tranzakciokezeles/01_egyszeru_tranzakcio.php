<?php

// =============================================================
// 6.17. Egyszerű tranzakció
// =============================================================

// Előkészítés a futtatáshoz (nem része a könyvbeli kódpéldának)
require __DIR__ . '/../db.php';

try {
    $pdo->beginTransaction();

    $stmt = $pdo->prepare("
        UPDATE accounts
        SET balance = balance - :amount
        WHERE id = :id
    ");
    $stmt->execute(['amount' => 100, 'id' => 1]);

    $stmt = $pdo->prepare("
        UPDATE accounts
        SET balance = balance + :amount
        WHERE id = :id
    ");
    $stmt->execute(['amount' => 100, 'id' => 2]);

    $pdo->commit();
    echo "Sikeres tranzakció!";

} catch (Exception $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    error_log("Tranzakciós hiba: " . $e->getMessage());
    die("Tranzakciós hiba.");
}

// Kiegészítés (nem szerepel a könyvben): a számlák egyenlege
echo "<br>";
foreach ($pdo->query("SELECT id, account_number, balance FROM accounts") as $row) {
    echo "#{$row['id']} ({$row['account_number']}): {$row['balance']}<br>";
}
