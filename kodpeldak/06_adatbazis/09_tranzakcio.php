<?php
require_once '00_db.php';

function transferMoney(PDO $pdo, string $from, string $to, float $amount): bool
{
    try {
        $pdo->beginTransaction();

        // 1. Levonás a küldő számláról
        $stmt = $pdo->prepare("
            UPDATE accounts
            SET balance = balance - :amount
            WHERE account_number = :account AND balance >= :min_balance
        ");
        $stmt->execute(['amount' => $amount, 'account' => $from, 'min_balance' => $amount]);

        if ($stmt->rowCount() === 0) {
            throw new Exception("Nincs elegendő fedezet vagy érvénytelen számla!");
        }

        // 2. Jóváírás a fogadó számlán
        $stmt = $pdo->prepare("
            UPDATE accounts
            SET balance = balance + :amount
            WHERE account_number = :account
        ");
        $stmt->execute(['amount' => $amount, 'account' => $to]);

        if ($stmt->rowCount() === 0) {
            throw new Exception("Fogadó számla nem található!");
        }

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

$before  = $pdo->query("SELECT account_number, owner_name, balance FROM accounts ORDER BY id")->fetchAll();
$success = transferMoney($pdo, '12345', '67890', 500.00);
$after   = $pdo->query("SELECT account_number, owner_name, balance FROM accounts ORDER BY id")->fetchAll();
?><!DOCTYPE html>
<html lang="hu">
<head><meta charset="UTF-8"><title>Tranzakció</title></head>
<body>

<h1>Banki átutalás – tranzakció példa</h1>
<p>Átutalás: 500 RON a <code>12345</code> számláról a <code>67890</code>-re.</p>
<p><strong><?= $success ? '✓ Sikeres átutalás!' : '✗ Az átutalás sikertelen.' ?></strong></p>

<table border="1" cellpadding="6">
    <tr><th>Számlaszám</th><th>Tulajdonos</th><th>Előtte</th><th>Utána</th></tr>
    <?php for ($i = 0; $i < count($before); $i++): ?>
    <tr>
        <td><?= htmlspecialchars($before[$i]['account_number']) ?></td>
        <td><?= htmlspecialchars($before[$i]['owner_name']) ?></td>
        <td><?= number_format((float)$before[$i]['balance'], 2) ?> RON</td>
        <td><?= number_format((float)$after[$i]['balance'],  2) ?> RON</td>
    </tr>
    <?php endfor; ?>
</table>

</body>
</html>
