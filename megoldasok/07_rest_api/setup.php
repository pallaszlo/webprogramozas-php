<?php
// A Stocks API adatbázisának telepítése.
// Böngészőből vagy parancssorból (php setup.php) kell futtatni.
// A setup.sql utasításait hajtja végre. Az újrafuttatás visszaállítja a kiinduló állapotot.
// Eltérő kapcsolati adatok esetén itt és az api/config.php-ban is módosítani kell őket.

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
    <title>Stocks API telepítése</title>
    <style>
        body { font-family: sans-serif; max-width: 700px; margin: 2em auto; }
        .ok  { color: green; }
        .err { color: red; }
        pre  { background: #f4f4f4; padding: 0.8em; }
    </style>
</head>
<body>

<h1>Stocks API – adatbázis (stocks_api)</h1>

<ul>
    <?php foreach ($steps as [$status, $msg]): ?>
        <li class="<?= $status ?>"><?= $status === 'ok' ? '✓' : '✗' ?> <?= $msg ?></li>
    <?php endforeach; ?>
</ul>

<?php if ($ok): ?>
    <p class="ok"><strong>A telepítés sikeres.</strong></p>
    <p>Mintafelhasználó: <code>admin@example.com</code>, jelszó: <code>secret123</code>.</p>
    <p>Az API indítása:</p>
    <pre>php -S localhost:8081 api/index.php</pre>
    <p>Az API a <a href="curl_test.php">curl_test.php</a> szkripttel tesztelhető.</p>
<?php else: ?>
    <p class="err"><strong>A telepítés sikertelen.</strong>
    Ellenőrizzük a kapcsolati adatokat a szkript elején.</p>
<?php endif; ?>

</body>
</html>
