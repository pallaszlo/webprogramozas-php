<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: step1.php');
    exit;
}

$felhasznalonev = htmlspecialchars(trim($_POST['felhasznalonev'] ?? ''));
$email          = htmlspecialchars(trim($_POST['email']          ?? ''));
$telefon        = htmlspecialchars(trim($_POST['telefon']        ?? ''));
$lakhely        = htmlspecialchars(trim($_POST['lakhely']        ?? ''));
$szuletesi_ev   = (int) ($_POST['szuletesi_ev'] ?? 0);
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Regisztráció kész</title>
</head>
<body>

<h1>Regisztráció sikeres!</h1>
<p>Az összes megadott adat:</p>

<table border="1" cellpadding="6">
    <tr><th>Felhasználónév</th><td><?= $felhasznalonev ?></td></tr>
    <tr><th>E-mail</th><td><?= $email ?></td></tr>
    <tr><th>Telefon</th><td><?= $telefon ?: '(nincs megadva)' ?></td></tr>
    <tr><th>Lakhely</th><td><?= $lakhely ?></td></tr>
    <tr><th>Születési év</th><td><?= $szuletesi_ev ?: '(nincs megadva)' ?></td></tr>
</table>

<p><a href="step1.php">Újrakezdés</a></p>

</body>
</html>
