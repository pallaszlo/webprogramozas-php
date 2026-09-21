<?php
// A Student API adatbázisának telepítése (a könyv 7.9. kódpéldája alapján).
// Böngészőből vagy parancssorból (php setup.php) kell futtatni.
// A database.sql utasításait hajtja végre. Az újrafuttatás visszaállítja a kiinduló állapotot.
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

    $sql = file_get_contents(__DIR__ . '/database.sql');
    $sql = preg_replace('/^--.*$/m', '', $sql);
    foreach (preg_split('/;\s*$/m', $sql) as $statement) {
        $statement = trim($statement);
        if ($statement === '') {
            continue;
        }
        // a tábla újralétrehozása előtt a régit töröljük
        if (preg_match('/^CREATE TABLE (\w+)/', $statement, $m)) {
            $pdo->exec("DROP TABLE IF EXISTS {$m[1]}");
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
    <title>Student API telepítése</title>
    <style>
        body { font-family: sans-serif; max-width: 700px; margin: 2em auto; }
        .ok  { color: green; }
        .err { color: red; }
        pre  { background: #f4f4f4; padding: 0.8em; }
    </style>
</head>
<body>

<h1>Student API – adatbázis (student_api)</h1>

<ul>
    <?php foreach ($steps as [$status, $msg]): ?>
        <li class="<?= $status ?>"><?= $status === 'ok' ? '✓' : '✗' ?> <?= $msg ?></li>
    <?php endforeach; ?>
</ul>

<?php if ($ok): ?>
    <p class="ok"><strong>A telepítés sikeres.</strong></p>
    <p>Az API a 06_rest_api_implementacio vagy a 07_biztonsag_rest_api_kban
    mappából indítható:</p>
    <pre>php -S localhost:8080 api/index.php</pre>
<?php else: ?>
    <p class="err"><strong>A telepítés sikertelen.</strong>
    Ellenőrizzük a kapcsolati adatokat a szkript elején.</p>
<?php endif; ?>

</body>
</html>
