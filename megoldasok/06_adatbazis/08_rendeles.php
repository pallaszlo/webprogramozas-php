<?php
require_once '01_db.php';

// Megrendelt tételek (demo adatok)
$orderItems = [
    ['product_id' => 1, 'quantity' => 1],  // Laptop
    ['product_id' => 3, 'quantity' => 2],  // PHP kézikönyv
];

$message = '';
$success = false;

if (isset($_POST['rendel'])) {
    try {
        $pdo->beginTransaction();

        $totalPrice = 0.0;
        $prepared   = [];

        // 1. Készlet ellenőrzése és egységárak lekérdezése
        foreach ($orderItems as $item) {
            $stmt = $pdo->prepare("SELECT id, name, price, stock FROM products WHERE id = :id");
            $stmt->execute(['id' => $item['product_id']]);
            $product = $stmt->fetch();

            if (!$product) {
                throw new Exception("Termék nem található (ID: {$item['product_id']}).");
            }

            if ($product['stock'] < $item['quantity']) {
                throw new Exception(
                    "Nincs elegendő készlet: {$product['name']} " .
                    "(kért: {$item['quantity']}, készleten: {$product['stock']})."
                );
            }

            $prepared[] = [
                'product_id' => $product['id'],
                'name'       => $product['name'],
                'quantity'   => $item['quantity'],
                'unit_price' => (float)$product['price'],
            ];
            $totalPrice += $product['price'] * $item['quantity'];
        }

        // 2. Rendelés fejléc felvétele
        $stmt = $pdo->prepare("
            INSERT INTO orders (total_price, created_at) VALUES (:total, NOW())
        ");
        $stmt->execute(['total' => $totalPrice]);
        $orderId = (int)$pdo->lastInsertId();

        // 3. Tételek + készlet csökkentése
        foreach ($prepared as $item) {
            $stmt = $pdo->prepare("
                INSERT INTO order_items (order_id, product_id, quantity, unit_price)
                VALUES (:order_id, :product_id, :quantity, :unit_price)
            ");
            $stmt->execute([
                'order_id'   => $orderId,
                'product_id' => $item['product_id'],
                'quantity'   => $item['quantity'],
                'unit_price' => $item['unit_price'],
            ]);

            $stmt = $pdo->prepare("
                UPDATE products SET stock = stock - :qty WHERE id = :id
            ");
            $stmt->execute(['qty' => $item['quantity'], 'id' => $item['product_id']]);
        }

        $pdo->commit();
        $success = true;
        $message = "Sikeres rendelés! Azonosító: $orderId | Végösszeg: "
                 . number_format($totalPrice, 2) . " RON";

    } catch (Exception $e) {
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        error_log("Rendelési hiba: " . $e->getMessage());
        $message = "Hiba: " . $e->getMessage();
    }
}

$products = $pdo->query("SELECT id, name, price, stock FROM products ORDER BY id")->fetchAll();
?><!DOCTYPE html>
<html lang="hu">
<head><meta charset="UTF-8"><title>Rendelés leadása</title></head>
<body>

<h1>Rendelés leadása – tranzakcióval</h1>

<h2>Leadandó rendelés</h2>
<ul>
    <?php foreach ($orderItems as $item): ?>
        <li>Termék ID <?= (int)$item['product_id'] ?> × <?= (int)$item['quantity'] ?> db</li>
    <?php endforeach; ?>
</ul>

<form method="POST">
    <button type="submit" name="rendel" value="1">Rendelés leadása</button>
</form>

<?php if ($message): ?>
    <p style="color:<?= $success ? 'green' : 'red' ?>">
        <strong><?= htmlspecialchars($message) ?></strong>
    </p>
<?php endif; ?>

<h2>Aktuális készletek</h2>
<table border="1" cellpadding="6">
    <tr><th>ID</th><th>Név</th><th>Ár (RON)</th><th>Készlet</th></tr>
    <?php foreach ($products as $p): ?>
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
