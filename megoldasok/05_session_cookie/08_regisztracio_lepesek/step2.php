<?php
session_start();

if (empty($_SESSION['reg'])) {
    header('Location: step1.php');
    exit;
}

if (isset($_POST['tovabb'])) {
    $_SESSION['reg']['varos']    = htmlspecialchars(trim($_POST['varos']    ?? ''));
    $_SESSION['reg']['utca']     = htmlspecialchars(trim($_POST['utca']     ?? ''));
    $_SESSION['reg']['hazszam']  = htmlspecialchars(trim($_POST['hazszam']  ?? ''));
    $_SESSION['reg']['lepes']    = 2;

    header('Location: step3.php');
    exit;
}

$d = $_SESSION['reg'];
?>
<!DOCTYPE html>
<html lang="hu">
<head><meta charset="UTF-8"><title>Regisztráció – 2. lépés</title></head>
<body>

<h1>Regisztráció – 2/3: Lakcím</h1>
<p>1. lépés: személyes adatok &nbsp;|&nbsp; <strong>2. lépés: lakcím</strong> &nbsp;|&nbsp; 3. lépés: fiókadatok</p>

<form method="POST">
    <p><label>Város: <input type="text" name="varos" value="<?= $d['varos'] ?? '' ?>" required></label></p>
    <p><label>Utca: <input type="text" name="utca" value="<?= $d['utca'] ?? '' ?>"></label></p>
    <p><label>Házszám: <input type="text" name="hazszam" value="<?= $d['hazszam'] ?? '' ?>"></label></p>
    <a href="step1.php">← Vissza</a>
    <button type="submit" name="tovabb" value="1">Tovább →</button>
</form>

</body>
</html>
