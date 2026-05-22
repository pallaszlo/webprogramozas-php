<?php
// Szimulált felhasználói adatbázis hash-elt jelszavakkal
$felhasznalok = [
    'admin' => password_hash('titkosjelszo', PASSWORD_DEFAULT),
    'tanulo' => password_hash('jelszo123',   PASSWORD_DEFAULT),
];

$uzenet  = '';
$sikeres = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nev    = trim($_POST['nev']    ?? '');
    $jelszo = trim($_POST['jelszo'] ?? '');

    if (isset($felhasznalok[$nev])) {
        if (password_verify($jelszo, $felhasznalok[$nev])) {
            // Szükséges-e frissebb hash algoritmussal újrahash-elni?
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
        $uzenet = 'A felhasználónév nem található.';
    }
}
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Bejelentkezés – jelszókezelés</title>
</head>
<body>

<h1>Bejelentkezés</h1>

<p><em>Teszt fiókok: <code>admin / titkosjelszo</code>, <code>tanulo / jelszo123</code></em></p>

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

</body>
</html>
