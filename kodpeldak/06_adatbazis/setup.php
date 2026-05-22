<?php
// Demo adatbázis telepítő szkript
// Futtasd böngészőből egyszer, ezután használhatod a többi példát.
// Módosítsd a kapcsolati adatokat, ha szükséges.

$host     = 'localhost';
$username = 'root';
$password = '';
$dbname   = 'demo_db';

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

    // Táblák törlése (tiszta állapot)
    $pdo->exec("DROP TABLE IF EXISTS orders");
    $pdo->exec("DROP TABLE IF EXISTS accounts");
    $pdo->exec("DROP TABLE IF EXISTS users");
    $steps[] = ['ok', "Régi táblák eltávolítva (ha léteztek)"];

    // users tábla
    $pdo->exec("
        CREATE TABLE users (
            id         INT AUTO_INCREMENT PRIMARY KEY,
            username   VARCHAR(100)  NOT NULL UNIQUE,
            email      VARCHAR(255)  NOT NULL UNIQUE,
            age        INT           NOT NULL,
            city       VARCHAR(100),
            created_at DATETIME      NOT NULL DEFAULT NOW()
        )
    ");
    $steps[] = ['ok', "Tábla létrehozva: <code>users</code>"];

    // accounts tábla
    $pdo->exec("
        CREATE TABLE accounts (
            id             INT           AUTO_INCREMENT PRIMARY KEY,
            account_number VARCHAR(20)   NOT NULL UNIQUE,
            owner_name     VARCHAR(100)  NOT NULL,
            balance        DECIMAL(12,2) NOT NULL DEFAULT 0.00
        )
    ");
    $steps[] = ['ok', "Tábla létrehozva: <code>accounts</code>"];

    // Mintaadatok – users
    $pdo->exec("
        INSERT INTO users (username, email, age, city) VALUES
            ('kiss_janos',   'kiss.janos@example.com',   25, 'Budapest'),
            ('nagy_peter',   'nagy.peter@example.com',    32, 'Debrecen'),
            ('kovacs_anna',  'kovacs.anna@example.com',   28, 'Budapest'),
            ('toth_maria',   'toth.maria@example.com',    45, 'Pécs'),
            ('szabo_laszlo', 'szabo.laszlo@example.com',  19, 'Győr')
    ");
    $steps[] = ['ok', "Mintaadatok betöltve: <code>users</code> (5 rekord)"];

    // Mintaadatok – accounts
    $pdo->exec("
        INSERT INTO accounts (account_number, owner_name, balance) VALUES
            ('12345', 'Kiss János',  5000.00),
            ('67890', 'Nagy Péter',  1000.00)
    ");
    $steps[] = ['ok', "Mintaadatok betöltve: <code>accounts</code> (2 rekord)"];

} catch (PDOException $e) {
    $steps[] = ['err', "Hiba: " . htmlspecialchars($e->getMessage())];
    $ok = false;
}
?><!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Demo adatbázis telepítés</title>
    <style>
        body { font-family: sans-serif; max-width: 700px; margin: 2em auto; }
        .ok  { color: green; }
        .err { color: red;   }
        li   { margin: 0.3em 0; }
    </style>
</head>
<body>

<h1>Demo adatbázis telepítő</h1>
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
    Most már futtathatod a többi példát.</p>
    <ul>
        <li><a href="01_kapcsolat.php">01 – Kapcsolat</a></li>
        <li><a href="03_prepared_select.php">03 – SELECT</a></li>
        <li><a href="04_fetch_modok.php">04 – Fetch módok</a></li>
        <li><a href="05_insert.php">05 – INSERT</a></li>
        <li><a href="06_update.php">06 – UPDATE</a></li>
        <li><a href="07_delete.php">07 – DELETE</a></li>
        <li><a href="08_repository.php">08 – Repository</a></li>
        <li><a href="09_tranzakcio.php">09 – Tranzakció</a></li>
        <li><a href="10_n_plus_1.php">10 – N+1 probléma</a></li>
        <li><a href="11_lapozas.php">11 – Lapozás</a></li>
    </ul>
<?php else: ?>
    <p style="color:red"><strong>Telepítés sikertelen.</strong>
    Ellenőrizd a kapcsolati adatokat a szkript elején.</p>
<?php endif; ?>

</body>
</html>
