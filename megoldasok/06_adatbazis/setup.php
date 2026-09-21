<?php
// A webshop adatbázis telepítése a 6. fejezet gyakorló feladataihoz.
// Böngészőből vagy parancssorból (php setup.php) kell futtatni.
// A setup.sql utasításait hajtja végre. Az újrafuttatás visszaállítja a kiinduló állapotot.
// Eltérő kapcsolati adatok esetén itt és a 01_db.php-ban is módosítani kell őket.

$host     = 'localhost';
$username = 'root';
$password = '';

$steps = [];
$ok    = true;

try {
    $pdo = new PDO("mysql:host=$host;charset=utf8mb4", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);
    $steps[] = ['ok', 'Kapcsolódás az adatbázis-szerverhez: sikeres'];

    // Az SQL-utasításokat a sor végi pontosvesszőnél bontjuk szét
    $sql = file_get_contents(__DIR__ . '/setup.sql');
    $sql = preg_replace('/^--.*$/m', '', $sql);
    foreach (preg_split('/;\s*$/m', $sql) as $statement) {
        $statement = trim($statement);
        if ($statement === '') {
            continue;
        }
        $pdo->exec($statement);
        $steps[] = ['ok', htmlspecialchars(strtok($statement, "\n"))];
    }
} catch (PDOException $e) {
    $steps[] = ['err', 'Hiba: ' . htmlspecialchars($e->getMessage())];
    $ok = false;
}

if (PHP_SAPI === 'cli') {
    foreach ($steps as [$status, $msg]) {
        echo ($status === 'ok' ? '✓ ' : '✗ ') . html_entity_decode($msg) . "\n";
    }
    exit($ok ? 0 : 1);
}
?><!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Webshop adatbázis telepítése</title>
    <style>
        body { font-family: sans-serif; max-width: 700px; margin: 2em auto; }
        .ok  { color: green; }
        .err { color: red; }
        li   { margin: 0.2em 0; }
    </style>
</head>
<body>

<h1>A gyakorló feladatok adatbázisa (webshop)</h1>

<ul>
    <?php foreach ($steps as [$status, $msg]): ?>
        <li class="<?= $status ?>"><?= $status === 'ok' ? '✓' : '✗' ?> <?= $msg ?></li>
    <?php endforeach; ?>
</ul>

<?php if ($ok): ?>
    <p class="ok"><strong>A telepítés sikeres.</strong> A megoldások:</p>
    <ul>
        <li><a href="02_lista.php">02 – Termékek listája</a></li>
        <li><a href="03_termek_felvetel.php">03 – Termék felvétele</a></li>
        <li><a href="04_termek_szerkesztes.php?id=1">04 – Termék szerkesztése</a></li>
        <li><a href="05_termek_torles.php?id=4">05 – Termék törlése</a></li>
        <li><a href="06_repository/index.php">06 – ProductRepository</a></li>
        <li><a href="07_kategorias_lista.php">07 – Kategóriás lista és lapozás</a></li>
        <li><a href="08_rendeles.php">08 – Rendelés leadása</a></li>
    </ul>
<?php else: ?>
    <p class="err"><strong>A telepítés sikertelen.</strong>
    Ellenőrizzük a kapcsolati adatokat a szkript elején.</p>
<?php endif; ?>

</body>
</html>
