<?php
session_start();

if (empty($_SESSION['reg']) || ($_SESSION['reg']['lepes'] ?? 0) < 2) {
    header('Location: step1.php');
    exit;
}

if (isset($_POST['veglegesit'])) {
    $_SESSION['reg']['felhasznalonev'] = trim($_POST['felhasznalonev'] ?? '');
    // A jelszót csak hash formában tároljuk, és nem jelenítjük meg
    $_SESSION['reg']['jelszo_hash'] = password_hash($_POST['jelszo'] ?? '', PASSWORD_DEFAULT);

    header('Location: done.php');
    exit;
}

$d = $_SESSION['reg'];
?>
<!DOCTYPE html>
<html lang="hu">
<head><meta charset="UTF-8"><title>Regisztráció – 3. lépés</title></head>
<body>

<h1>Regisztráció – 3/3: Fiókadatok</h1>
<p>1. lépés: személyes adatok &nbsp;|&nbsp; 2. lépés: lakcím &nbsp;|&nbsp; <strong>3. lépés: fiókadatok</strong></p>

<form method="POST">
    <p><label>Felhasználónév: <input type="text" name="felhasznalonev" value="<?= htmlspecialchars($d['felhasznalonev'] ?? '') ?>" required></label></p>
    <p><label>Jelszó: <input type="password" name="jelszo" required></label></p>
    <a href="step2.php">← Vissza</a>
    <button type="submit" name="veglegesit" value="1">Regisztráció befejezése</button>
</form>

</body>
</html>
