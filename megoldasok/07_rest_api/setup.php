<?php
// Stocks API adatbázis telepítő szkript
// Futtasd böngészőből egyszer, ezután indítsd el az API szervert:
//   php -S localhost:8081 api/index.php

$host     = 'localhost';
$username = 'root';
$password = '';
$dbname   = 'stocks_api';

$steps = [];
$ok    = true;

try {
    $pdo = new PDO(
        "mysql:host=$host;charset=utf8mb4",
        $username,
        $password,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    $steps[] = ['ok', 'Kapcsolódás MySQL szerverhez: sikeres'];

    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbname`
        CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    $steps[] = ['ok', "Adatbázis létrehozva: <code>$dbname</code>"];

    $pdo->exec("USE `$dbname`");

    // Törlés helyes sorrendben (foreign key miatt)
    $pdo->exec("DROP TABLE IF EXISTS stocks");
    $pdo->exec("DROP TABLE IF EXISTS sectors");
    $pdo->exec("DROP TABLE IF EXISTS users");
    $steps[] = ['ok', 'Régi táblák eltávolítva (ha léteztek)'];

    $pdo->exec("
        CREATE TABLE sectors (
            id   INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL UNIQUE
        )
    ");
    $steps[] = ['ok', 'Tábla létrehozva: <code>sectors</code>'];

    $pdo->exec("
        CREATE TABLE stocks (
            id           INT AUTO_INCREMENT PRIMARY KEY,
            ticker       VARCHAR(10)   NOT NULL UNIQUE,
            company_name VARCHAR(100)  NOT NULL,
            sector_id    INT,
            price        DECIMAL(10,2) NOT NULL,
            created_at   DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (sector_id) REFERENCES sectors(id)
        )
    ");
    $steps[] = ['ok', 'Tábla létrehozva: <code>stocks</code>'];

    $pdo->exec("
        CREATE TABLE users (
            id       INT AUTO_INCREMENT PRIMARY KEY,
            email    VARCHAR(255) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL
        )
    ");
    $steps[] = ['ok', 'Tábla létrehozva: <code>users</code>'];

    $pdo->exec("
        INSERT INTO sectors (name) VALUES
            ('Technology'), ('Finance'), ('Healthcare'), ('Energy')
    ");
    $steps[] = ['ok', 'Mintaadatok betöltve: <code>sectors</code> (4 rekord)'];

    $pdo->exec("
        INSERT INTO stocks (ticker, company_name, sector_id, price) VALUES
            ('AAPL',  'Apple Inc.',        1, 189.30),
            ('MSFT',  'Microsoft Corp.',   1, 415.50),
            ('GOOGL', 'Alphabet Inc.',     1, 175.20),
            ('JPM',   'JPMorgan Chase',    2, 198.40),
            ('JNJ',   'Johnson & Johnson', 3, 147.80)
    ");
    $steps[] = ['ok', 'Mintaadatok betöltve: <code>stocks</code> (5 rekord)'];

    // Demo felhasználó (jelszó: secret123)
    $hash = password_hash('secret123', PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO users (email, password) VALUES (:email, :password)");
    $stmt->execute([':email' => 'admin@example.com', ':password' => $hash]);
    $steps[] = ['ok', 'Demo felhasználó létrehozva: <code>admin@example.com</code> / <code>secret123</code>'];

} catch (PDOException $e) {
    $steps[] = ['err', 'Hiba: ' . htmlspecialchars($e->getMessage())];
    $ok = false;
}
?><!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Stocks API telepítés</title>
    <style>
        body { font-family: sans-serif; max-width: 700px; margin: 2em auto; }
        .ok  { color: green; }
        .err { color: red; }
        li   { margin: 0.3em 0; }
        pre  { background: #f4f4f4; padding: 0.8em; border-radius: 4px; }
    </style>
</head>
<body>

<h1>Stocks API – adatbázis telepítő</h1>
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
    <p style="color:green"><strong>Telepítés sikeres!</strong></p>

    <h2>Az API indítása</h2>
    <pre>php -S localhost:8081 api/index.php</pre>

    <p>Az API teszteléséhez futtasd a <a href="curl_test.php">curl_test.php</a> szkriptet.</p>
<?php else: ?>
    <p style="color:red"><strong>Telepítés sikertelen.</strong>
    Ellenőrizd a kapcsolati adatokat a szkript elején.</p>
<?php endif; ?>

</body>
</html>
