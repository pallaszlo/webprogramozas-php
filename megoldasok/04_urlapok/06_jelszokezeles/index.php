<?php
// Szimulált felhasználói adatbázis hash-elt jelszavakkal.
// A tanulo jelszavát szándékosan kisebb költséggel (cost = 4) hash-eljük, mintha
// egy régebbi beállítással készült volna. Bejelentkezéskor ezt a
// password_needs_rehash() elavultnak jelzi, ezért új hash készül.
$felhasznalok = [
    'admin'  => password_hash('titkosjelszo', PASSWORD_DEFAULT),
    'tanulo' => password_hash('jelszo123', PASSWORD_BCRYPT, ['cost' => 4]),
];

$uzenet    = '';
$sikeres   = false;
$frissitve = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nev    = trim($_POST['nev']    ?? '');
    $jelszo = $_POST['jelszo'] ?? '';  // a jelszót nem vágjuk meg: a szóköz is a része lehet

    // Mindkét hibás esetben ugyanazt az üzenetet adjuk, így nem derül ki,
    // hogy egy felhasználónév létezik-e.
    if (isset($felhasznalok[$nev]) && password_verify($jelszo, $felhasznalok[$nev])) {
        // Megfelel-e a tárolt hash az aktuális algoritmusnak és beállításoknak? Ha nem, újat készítünk.
        if (password_needs_rehash($felhasznalok[$nev], PASSWORD_DEFAULT)) {
            $felhasznalok[$nev] = password_hash($jelszo, PASSWORD_DEFAULT);
            $frissitve = true;
            // Valós alkalmazásban: az új hash-t adatbázisba mentjük
        }
        $uzenet  = "Sikeres bejelentkezés! Üdvözöljük, {$nev}!";
        $sikeres = true;
    } else {
        $uzenet = 'Hibás felhasználónév vagy jelszó.';
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

<?php if ($frissitve): ?>
    <p>A tárolt jelszó-hash elavult volt, ezért új hash készült az aktuális beállításokkal.</p>
<?php endif; ?>

<form method="POST">
    <p><label>Felhasználónév: <input type="text" name="nev"></label></p>
    <p><label>Jelszó: <input type="password" name="jelszo"></label></p>
    <button type="submit">Bejelentkezés</button>
</form>

</body>
</html>
