<?php
// Student API adatbázis telepítő szkript
// Futtasd böngészőből egyszer, ezután indítsd el az API szervert:
//   php -S localhost:8080 api/index.php

$host     = 'localhost';
$username = 'root';
$password = '';
$dbname   = 'student_api';

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
    $pdo->exec("DROP TABLE IF EXISTS students");

    $pdo->exec("
        CREATE TABLE students (
            id         INT AUTO_INCREMENT PRIMARY KEY,
            name       VARCHAR(100)  NOT NULL,
            email      VARCHAR(100)  NOT NULL UNIQUE,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                            ON UPDATE CURRENT_TIMESTAMP
        )
    ");
    $steps[] = ['ok', 'Tábla létrehozva: <code>students</code>'];

    $pdo->exec("
        INSERT INTO students (name, email) VALUES
            ('Nagy János',   'nagy.janos@example.com'),
            ('Kiss Anna',    'kiss.anna@example.com'),
            ('Kovács Péter', 'kovacs.peter@example.com')
    ");
    $steps[] = ['ok', 'Mintaadatok betöltve: <code>students</code> (3 rekord)'];

} catch (PDOException $e) {
    $steps[] = ['err', 'Hiba: ' . htmlspecialchars($e->getMessage())];
    $ok = false;
}
?><!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Student API telepítés</title>
    <style>
        body { font-family: sans-serif; max-width: 700px; margin: 2em auto; }
        .ok  { color: green; }
        .err { color: red; }
        li   { margin: 0.3em 0; }
        pre  { background: #f4f4f4; padding: 0.8em; border-radius: 4px; }
    </style>
</head>
<body>

<h1>Student API – adatbázis telepítő</h1>
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
    <p>Futtasd az alábbi parancsot ebből a könyvtárból:</p>
    <pre>php -S localhost:8080 api/index.php</pre>

    <p>Az API teszteléséhez futtasd a <a href="curl_test.php">curl_test.php</a> szkriptet.</p>
<?php else: ?>
    <p style="color:red"><strong>Telepítés sikertelen.</strong>
    Ellenőrizd a kapcsolati adatokat a szkript elején.</p>
<?php endif; ?>

</body>
</html>
