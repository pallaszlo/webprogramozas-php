<?php
// Webshop adatbázis telepítő szkript
// Futtasd böngészőből egyszer, ezután használhatod a megoldásokat.
// Módosítsd a kapcsolati adatokat, ha szükséges.

$host     = 'localhost';
$username = 'root';
$password = '';
$dbname   = 'webshop';

$steps = [];
$ok    = true;

try {
    // Kapcsolódás adatbázis nélkül
    $pdo = new PDO(
        "mysql:host=$host;charset=utf8mb4",
        $username,
        $password,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    $steps[] = ['ok', "Kapcsolódás MySQL szerverhez: sikeres"];

    // Adatbázis létrehozása
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbname`
        CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    $steps[] = ['ok', "Adatbázis létrehozva: <code>$dbname</code>"];

    $pdo->exec("USE `$dbname`");

    // Táblák törlése helyes sorrendben (foreign key miatt)
    $pdo->exec("DROP TABLE IF EXISTS order_items");
    $pdo->exec("DROP TABLE IF EXISTS orders");
    $pdo->exec("DROP TABLE IF EXISTS products");
    $pdo->exec("DROP TABLE IF EXISTS categories");
    $steps[] = ['ok', "Régi táblák eltávolítva (ha léteztek)"];

    // categories
    $pdo->exec("
        CREATE TABLE categories (
            id   INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL UNIQUE
        )
    ");
    $steps[] = ['ok', "Tábla létrehozva: <code>categories</code>"];

    // products
    $pdo->exec("
        CREATE TABLE products (
            id          INT AUTO_INCREMENT PRIMARY KEY,
            name        VARCHAR(255)  NOT NULL UNIQUE,
            price       DECIMAL(10,2) NOT NULL,
            stock       INT           NOT NULL DEFAULT 0,
            category_id INT,
            FOREIGN KEY (category_id) REFERENCES categories(id)
        )
    ");
    $steps[] = ['ok', "Tábla létrehozva: <code>products</code>"];

    // orders
    $pdo->exec("
        CREATE TABLE orders (
            id          INT AUTO_INCREMENT PRIMARY KEY,
            total_price DECIMAL(10,2) NOT NULL,
            created_at  DATETIME      NOT NULL
        )
    ");
    $steps[] = ['ok', "Tábla létrehozva: <code>orders</code>"];

    // order_items
    $pdo->exec("
        CREATE TABLE order_items (
            id         INT AUTO_INCREMENT PRIMARY KEY,
            order_id   INT           NOT NULL,
            product_id INT           NOT NULL,
            quantity   INT           NOT NULL,
            unit_price DECIMAL(10,2) NOT NULL,
            FOREIGN KEY (order_id)   REFERENCES orders(id),
            FOREIGN KEY (product_id) REFERENCES products(id)
        )
    ");
    $steps[] = ['ok', "Tábla létrehozva: <code>order_items</code>"];

    // Mintaadatok
    $pdo->exec("
        INSERT INTO categories (name) VALUES ('Elektronika'), ('Könyvek'), ('Ruházat')
    ");
    $steps[] = ['ok', "Mintaadatok betöltve: <code>categories</code> (3 rekord)"];

    $pdo->exec("
        INSERT INTO products (name, price, stock, category_id) VALUES
            ('Laptop',         1499.99, 10, 1),
            ('Okostelefon',     799.00,  5, 1),
            ('PHP kézikönyv',   49.90, 20, 2),
            ('Póló',            29.90, 50, 3)
    ");
    $steps[] = ['ok', "Mintaadatok betöltve: <code>products</code> (4 rekord)"];

} catch (PDOException $e) {
    $steps[] = ['err', "Hiba: " . htmlspecialchars($e->getMessage())];
    $ok = false;
}
?><!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Webshop adatbázis telepítés</title>
    <style>
        body { font-family: sans-serif; max-width: 700px; margin: 2em auto; }
        .ok  { color: green; }
        .err { color: red;   }
        li   { margin: 0.3em 0; }
    </style>
</head>
<body>

<h1>Webshop adatbázis telepítő</h1>
<p>Adatbázis: <code><?= htmlspecialchars($dbname) ?></code> &nbsp;|&nbsp;
   Szerver: <code><?= htmlspecialchars($host) ?></code></p>

<ul>
    <?php foreach ($steps as [$status, $msg]): ?>
        <li class="<?= $status ?>">
            <?= $status === 'ok' ? '✓' : '✗' ?> <?= $msg ?>
        </li>
    <?php endforeach; ?>
</ul>

<?php if ($ok): ?>
    <p style="color:green"><strong>Telepítés sikeres!</strong>
    Most már futtathatod a megoldásokat.</p>
    <ul>
        <li><a href="02_lista.php">02 – Termékek listája</a></li>
        <li><a href="03_termek_felvetel.php">03 – Termék felvétele</a></li>
        <li><a href="04_termek_szerkesztes.php?id=1">04 – Termék szerkesztése</a></li>
        <li><a href="05_termek_torles.php?id=4">05 – Termék törlése</a></li>
        <li><a href="06_repository/index.php">06 – ProductRepository</a></li>
        <li><a href="07_kategorias_lista.php">07 – Kategóriás lista + lapozás</a></li>
        <li><a href="08_rendeles.php">08 – Rendelés leadása</a></li>
    </ul>
<?php else: ?>
    <p style="color:red"><strong>Telepítés sikertelen.</strong>
    Ellenőrizd a kapcsolati adatokat a szkript elején.</p>
<?php endif; ?>

</body>
</html>
