<?php
// Az adatbázis telepítése a 6. fejezet kódpéldáihoz.
// Böngészőből vagy parancssorból (php setup.php) kell futtatni.
// A setup.sql utasításait hajtja végre.
// Az újrafuttatás visszaállítja az adatbázis kiinduló állapotát.
// Eltérő kapcsolati adatok esetén itt és a db.php-ban is módosítani kell őket.

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

// a példák listája alfejezetenként
$examples = glob(__DIR__ . '/0*/*.php');
?><!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Adatbázis telepítése</title>
    <style>
        body { font-family: sans-serif; max-width: 760px; margin: 2em auto; }
        .ok  { color: green; }
        .err { color: red; }
        li   { margin: 0.2em 0; }
    </style>
</head>
<body>

<h1>A 6. fejezet adatbázisa (mydb)</h1>

<ul>
    <?php foreach ($steps as [$status, $msg]): ?>
        <li class="<?= $status ?>"><?= $status === 'ok' ? '✓' : '✗' ?> <?= $msg ?></li>
    <?php endforeach; ?>
</ul>

<?php if ($ok): ?>
    <p class="ok"><strong>A telepítés sikeres.</strong> A példák:</p>
    <ul>
        <?php foreach ($examples as $file): ?>
            <?php $rel = basename(dirname($file)) . '/' . basename($file); ?>
            <li><a href="<?= htmlspecialchars($rel) ?>"><?= htmlspecialchars($rel) ?></a></li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p class="err"><strong>A telepítés sikertelen.</strong>
    Ellenőrizzük a kapcsolati adatokat a szkript elején.</p>
<?php endif; ?>

</body>
</html>
