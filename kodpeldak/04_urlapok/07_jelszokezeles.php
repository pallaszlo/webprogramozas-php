<?php
// Szimulált felhasználói adatbázis – jelszavak hash-elt formában
$felhasznalok = [
    'admin' => password_hash('titkosjelszo', PASSWORD_DEFAULT),
    'user1' => password_hash('jelszo123',    PASSWORD_DEFAULT),
];

$uzenet = '';
$sikeres = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nev    = $_POST['nev']    ?? '';
    $jelszo = $_POST['jelszo'] ?? '';

    if (isset($felhasznalok[$nev])) {
        if (password_verify($jelszo, $felhasznalok[$nev])) {
            // Szükséges-e újrahash-elés?
            if (password_needs_rehash($felhasznalok[$nev], PASSWORD_DEFAULT)) {
                $felhasznalok[$nev] = password_hash($jelszo, PASSWORD_DEFAULT);
                // Valós alkalmazásban: az új hash-t adatbázisba mentjük
            }
            $uzenet  = "Sikeres bejelentkezés! Üdvözöljük, {$nev}!";
            $sikeres = true;
        } else {
            $uzenet = 'Hibás jelszó.';
        }
    } else {
        $uzenet = 'A felhasználó nem található.';
    }
}
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Jelszókezelés</title>
</head>
<body>

<h1>Bejelentkezés – biztonságos jelszókezelés</h1>

<p><em>Teszt fiókok: <code>admin / titkosjelszo</code>, <code>user1 / jelszo123</code></em></p>

<?php if ($uzenet): ?>
    <p style="color:<?= $sikeres ? 'green' : 'red' ?>;">
        <?= htmlspecialchars($uzenet) ?>
    </p>
<?php endif; ?>

<form method="POST">
    <p><label>Felhasználónév: <input type="text" name="nev"></label></p>
    <p><label>Jelszó: <input type="password" name="jelszo"></label></p>
    <button type="submit">Bejelentkezés</button>
</form>

<h2>Hash-elt jelszavak (demonstrációs célból)</h2>
<?php foreach ($felhasznalok as $nev => $hash): ?>
    <p><strong><?= htmlspecialchars($nev) ?>:</strong><br>
    <code style="font-size:0.8em;"><?= htmlspecialchars($hash) ?></code></p>
<?php endforeach; ?>

</body>
</html>
