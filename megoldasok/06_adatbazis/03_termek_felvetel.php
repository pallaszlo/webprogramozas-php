<?php
require_once '01_db.php';

$errors  = [];
$success = '';
$form    = ['name' => '', 'price' => '', 'stock' => '0', 'category_id' => ''];

$categories = $pdo->query("SELECT id, name FROM categories ORDER BY name")->fetchAll();

if (isset($_POST['felvenni'])) {
    $form['name']        = trim($_POST['name']        ?? '');
    $form['price']       = trim($_POST['price']       ?? '');
    $form['stock']       = trim($_POST['stock']       ?? '');
    $form['category_id'] = $_POST['category_id']      ?? '';

    // Validáció
    if ($form['name'] === '') {
        $errors[] = "A terméknév kötelező.";
    }

    $price = filter_var($form['price'], FILTER_VALIDATE_FLOAT);
    if ($price === false || $price <= 0) {
        $errors[] = "Az ár érvényes pozitív szám kell legyen.";
    }

    $stock = filter_var($form['stock'], FILTER_VALIDATE_INT);
    if ($stock === false || $stock < 0) {
        $errors[] = "A raktárkészlet nemnegatív egész szám kell legyen.";
    }

    $catId = ($form['category_id'] !== '') ? (int)$form['category_id'] : null;

    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare("
                INSERT INTO products (name, price, stock, category_id)
                VALUES (:name, :price, :stock, :category_id)
            ");
            $stmt->execute([
                'name'        => $form['name'],
                'price'       => $price,
                'stock'       => $stock,
                'category_id' => $catId,
            ]);
            $newId   = (int)$pdo->lastInsertId();
            $success = "Termék sikeresen felvéve! Azonosító: $newId";
            $form    = ['name' => '', 'price' => '', 'stock' => '0', 'category_id' => ''];
        } catch (PDOException $e) {
            if ((int)$e->getCode() === 23000) {
                $errors[] = "Ez a terméknév már létezik.";
            } else {
                error_log($e->getMessage());
                $errors[] = "Adatbázis-hiba történt.";
            }
        }
    }
}
?><!DOCTYPE html>
<html lang="hu">
<head><meta charset="UTF-8"><title>Új termék felvétele</title></head>
<body>

<h1>Új termék felvétele</h1>

<?php if ($success): ?>
    <p style="color:green"><strong><?= htmlspecialchars($success) ?></strong></p>
<?php endif; ?>

<?php if ($errors): ?>
    <ul style="color:red">
        <?php foreach ($errors as $err): ?>
            <li><?= htmlspecialchars($err) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<form method="POST">
    <p><label>Terméknév:
        <input type="text" name="name" value="<?= htmlspecialchars($form['name']) ?>" required>
    </label></p>
    <p><label>Ár (RON):
        <input type="text" name="price" value="<?= htmlspecialchars($form['price']) ?>">
    </label></p>
    <p><label>Raktárkészlet:
        <input type="number" name="stock" min="0" value="<?= htmlspecialchars($form['stock']) ?>">
    </label></p>
    <p><label>Kategória:
        <select name="category_id">
            <option value="">– nincs –</option>
            <?php foreach ($categories as $cat): ?>
                <option value="<?= (int)$cat['id'] ?>"
                    <?= ($form['category_id'] == $cat['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($cat['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </label></p>
    <button type="submit" name="felvenni" value="1">Termék felvétele</button>
</form>

<p><a href="02_lista.php">← Vissza a listához</a></p>

</body>
</html>
