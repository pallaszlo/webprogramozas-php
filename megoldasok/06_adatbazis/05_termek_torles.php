<?php
require_once '01_db.php';

$id      = (int)($_GET['id'] ?? 0);
$message = '';
$product = null;

if ($id > 0) {
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $product = $stmt->fetch() ?: null;
}

if (isset($_POST['torol']) && $product) {
    try {
        $stmt = $pdo->prepare("DELETE FROM products WHERE id = :id");
        $stmt->execute(['id' => $id]);

        if ($stmt->rowCount() > 0) {
            $message = "Termék sikeresen törölve.";
            $product = null;
        } else {
            $message = "Nem létező rekord.";
        }
    } catch (PDOException $e) {
        if ((int)$e->getCode() === 23000) {
            $message = "Nem törölhető: rendelési tételek hivatkoznak erre a termékre (SQLSTATE 23000).";
        } else {
            error_log($e->getMessage());
            $message = "Adatbázis-hiba történt.";
        }
    }
}
?><!DOCTYPE html>
<html lang="hu">
<head><meta charset="UTF-8"><title>Termék törlése</title></head>
<body>

<h1>Termék törlése</h1>

<?php if ($message): ?>
    <p><strong><?= htmlspecialchars($message) ?></strong></p>
<?php endif; ?>

<?php if ($product): ?>
    <p>Biztosan törlöd az alábbi terméket?</p>
    <table border="1" cellpadding="6">
        <tr><th>ID</th><th>Név</th><th>Ár (RON)</th><th>Készlet</th></tr>
        <tr>
            <td><?= (int)$product['id'] ?></td>
            <td><?= htmlspecialchars($product['name']) ?></td>
            <td><?= number_format((float)$product['price'], 2) ?></td>
            <td><?= (int)$product['stock'] ?></td>
        </tr>
    </table>
    <form method="POST" action="?id=<?= $id ?>">
        <button type="submit" name="torol" value="1">Igen, törlés</button>
        <a href="02_lista.php">Mégsem</a>
    </form>
<?php elseif ($id === 0): ?>
    <p>Add meg az URL-ben az <code>id</code> paramétert (pl. <code>?id=1</code>).</p>
<?php endif; ?>

<p><a href="02_lista.php">← Vissza a listához</a></p>

</body>
</html>
