<?php
session_start();

if (empty($_SESSION['reg'])) {
    header('Location: step1.php');
    exit;
}

$d = $_SESSION['reg'];

// Munkamenet törlése a regisztráció után
session_unset();
session_destroy();
?>
<!DOCTYPE html>
<html lang="hu">
<head><meta charset="UTF-8"><title>Regisztráció kész</title></head>
<body>

<h1>Regisztráció sikeres!</h1>
<p>Az összes megadott adat:</p>

<table border="1" cellpadding="6">
    <tr><th>Név</th><td><?= htmlspecialchars($d['nev']           ?? '') ?></td></tr>
    <tr><th>E-mail</th><td><?= htmlspecialchars($d['email']        ?? '') ?></td></tr>
    <tr><th>Telefon</th><td><?= htmlspecialchars($d['telefon']      ?? '') ?></td></tr>
    <tr><th>Város</th><td><?= htmlspecialchars($d['varos']         ?? '') ?></td></tr>
    <tr><th>Utca</th><td><?= htmlspecialchars($d['utca']          ?? '') ?></td></tr>
    <tr><th>Házszám</th><td><?= htmlspecialchars($d['hazszam']      ?? '') ?></td></tr>
    <tr><th>Felhasználónév</th><td><?= htmlspecialchars($d['felhasznalonev'] ?? '') ?></td></tr>
</table>

<p><a href="step1.php">Újabb regisztráció</a></p>

</body>
</html>
