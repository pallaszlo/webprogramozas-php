<?php
require_once '01_db.php';

$id      = (int)($_GET['id'] ?? 0);
$message = '';
$product = null;

$categories = $pdo->query("SELECT id, name FROM categories ORDER BY name")->fetchAll();

if ($id > 0) {
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $product = $stmt->fetch() ?: null;
}

if ($id > 0 && $product === null) {
    $message = "Nem létező termék (ID: $id).";
}

$errors = [];

if (isset($_POST['frissit']) && $product) {
    // Validáció (ugyanaz, mint az új termék felvételénél)
    $name  = trim($_POST['name'] ?? '');
    $price = filter_var(trim($_POST['price'] ?? ''), FILTER_VALIDATE_FLOAT);
    $stock = filter_var(trim($_POST['stock'] ?? ''), FILTER_VALIDATE_INT);
    $catId = ($_POST['category_id'] ?? '') !== '' ? (int)$_POST['category_id'] : null;

    if ($name === '') {
        $errors[] = "A terméknév kötelező.";
    }
    if ($price === false || $price <= 0) {
        $errors[] = "Az ár érvényes pozitív szám kell legyen.";
    }
    if ($stock === false || $stock < 0) {
        $errors[] = "A raktárkészlet nemnegatív egész szám kell legyen.";
    }

    // Hiba esetén a beküldött értékek maradnak az űrlapon
    if ($errors) {
        $product = array_merge($product, [
            'name'        => $name,
            'price'       => $_POST['price'] ?? '',
            'stock'       => $_POST['stock'] ?? '',
            'category_id' => $catId,
        ]);
    }
}

if (isset($_POST['frissit']) && $product && !$errors) {
    try {
        $stmt = $pdo->prepare("
            UPDATE products
            SET name = :name, price = :price, stock = :stock, category_id = :category_id
            WHERE id = :id
        ");
        $stmt->execute([
            'name'        => $name,
            'price'       => $price,
            'stock'       => $stock,
            'category_id' => $catId,
            'id'          => $id,
        ]);

        $message = $stmt->rowCount() > 0 ? "Sikeres módosítás!" : "Nem történt változás.";

        // Frissített adatok
        $stmt = $pdo->prepare("SELECT * FROM products WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $product = $stmt->fetch();

    } catch (PDOException $e) {
        if ((int)$e->getCode() === 23000) {
            $message = "Ez a terméknév már létezik.";
        } else {
            error_log($e->getMessage());
            $message = "Adatbázis-hiba történt.";
        }
    }
}
?><!DOCTYPE html>
<html lang="hu">
<head><meta charset="UTF-8"><title>Termék szerkesztése</title></head>
<body>

<h1>Termék szerkesztése</h1>

<?php if ($message): ?>
    <p><strong><?= htmlspecialchars($message) ?></strong></p>
<?php endif; ?>

<?php if ($errors): ?>
    <ul style="color:red">
        <?php foreach ($errors as $err): ?>
            <li><?= htmlspecialchars($err) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<?php if ($product): ?>
<form method="POST" action="?id=<?= $id ?>">
    <p><label>Terméknév:
        <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" required>
    </label></p>
    <p><label>Ár (RON):
        <input type="text" name="price" value="<?= htmlspecialchars((string)$product['price']) ?>">
    </label></p>
    <p><label>Raktárkészlet:
        <input type="number" name="stock" min="0" value="<?= htmlspecialchars((string)$product['stock']) ?>">
    </label></p>
    <p><label>Kategória:
        <select name="category_id">
            <option value="">– nincs –</option>
            <?php foreach ($categories as $cat): ?>
                <option value="<?= (int)$cat['id'] ?>"
                    <?= ($product['category_id'] == $cat['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($cat['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </label></p>
    <button type="submit" name="frissit" value="1">Mentés</button>
</form>
<?php elseif ($id === 0): ?>
    <p>Add meg az URL-ben az <code>id</code> paramétert (pl. <code>?id=1</code>).</p>
<?php endif; ?>

<p><a href="02_lista.php">← Vissza a listához</a></p>

</body>
</html>
