<?php
session_start();

if (isset($_POST['tovabb'])) {
    $_SESSION['reg']['nev']      = trim($_POST['nev']      ?? '');
    $_SESSION['reg']['email']    = trim($_POST['email']    ?? '');
    $_SESSION['reg']['telefon']  = trim($_POST['telefon']  ?? '');
    $_SESSION['reg']['lepes']    = 1;

    header('Location: step2.php');
    exit;
}

// A munkamenetben nyers szöveget tárolunk, HTML-kódolás csak kiíráskor történik.
$d = $_SESSION['reg'] ?? [];
?>
<!DOCTYPE html>
<html lang="hu">
<head><meta charset="UTF-8"><title>Regisztráció – 1. lépés</title></head>
<body>

<h1>Regisztráció – 1/3: Személyes adatok</h1>
<p>1. lépés: személyes adatok &nbsp;|&nbsp; 2. lépés: lakcím &nbsp;|&nbsp; 3. lépés: fiókadatok</p>

<form method="POST">
    <p><label>Név: <input type="text" name="nev" value="<?= htmlspecialchars($d['nev'] ?? '') ?>" required></label></p>
    <p><label>E-mail: <input type="email" name="email" value="<?= htmlspecialchars($d['email'] ?? '') ?>" required></label></p>
    <p><label>Telefonszám: <input type="text" name="telefon" value="<?= htmlspecialchars($d['telefon'] ?? '') ?>"></label></p>
    <button type="submit" name="tovabb" value="1">Tovább →</button>
</form>

</body>
</html>
