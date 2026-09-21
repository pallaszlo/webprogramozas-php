<?php

// =============================================================
// 6.18. Banki átutalás tranzakcióval
// =============================================================

// Előkészítés a futtatáshoz (nem része a könyvbeli kódpéldának)
require __DIR__ . '/../db.php';

function transferMoney(
    PDO $pdo,
    string $fromAccount,
    string $toAccount,
    float $amount
): bool {
    try {
        $pdo->beginTransaction();

        // 1. Pénz levonása a küldő számláról
        $stmt = $pdo->prepare("
            UPDATE accounts
            SET balance = balance - :amount
            WHERE account_number = :account
              AND balance >= :min_balance
        ");

        $stmt->execute([
            'amount'      => $amount,
            'account'     => $fromAccount,
            'min_balance' => $amount,
        ]);

        if ($stmt->rowCount() === 0) {
            throw new Exception("Nincs elegendő fedezet vagy érvénytelen számla!");
        }

        // 2. Pénz jóváírása a fogadó számlán
        $stmt = $pdo->prepare("
            UPDATE accounts
            SET balance = balance + :amount
            WHERE account_number = :account
        ");

        $stmt->execute([
            'amount'  => $amount,
            'account' => $toAccount
        ]);

        if ($stmt->rowCount() === 0) {
            throw new Exception("Fogadó számla nem található!");
        }

        // 3. Tranzakció naplózása
        $stmt = $pdo->prepare("
            INSERT INTO transactions (from_account, to_account, amount, created_at)
            VALUES (:from, :to, :amount, NOW())
        ");

        $stmt->execute([
            'from'   => $fromAccount,
            'to'     => $toAccount,
            'amount' => $amount
        ]);

        $pdo->commit();
        return true;

    } catch (Exception $e) {
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }

        error_log("Átutalási hiba: " . $e->getMessage());
        return false;
    }
}

// Használat
$success = transferMoney($pdo, '12345', '67890', 1000.00);

if ($success) {
    echo "Sikeres átutalás!";
} else {
    echo "Az átutalás sikertelen.";
}

// Kiegészítés (nem szerepel a könyvben): a számlák egyenlege
echo "<br>";
foreach ($pdo->query("SELECT id, account_number, balance FROM accounts") as $row) {
    echo "#{$row['id']} ({$row['account_number']}): {$row['balance']}<br>";
}
