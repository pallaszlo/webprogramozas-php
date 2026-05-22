<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: step1.php');
    exit;
}

$felhasznalonev = htmlspecialchars(trim($_POST['felhasznalonev'] ?? ''));
$email          = htmlspecialchars(trim($_POST['email']          ?? ''));
$jelszo         = htmlspecialchars(trim($_POST['jelszo']         ?? ''));
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>2. lépés – További adatok</title>
</head>
<body>

<h1>Kétlépéses regisztráció – 2. lépés</h1>
<p>További adatok megadása</p>

<form method="POST" action="done.php">
    <!-- Az 1. lépés adatai rejtett mezőkben -->
    <input type="hidden" name="felhasznalonev" value="<?= $felhasznalonev ?>">
    <input type="hidden" name="email"          value="<?= $email ?>">
    <input type="hidden" name="jelszo"         value="<?= $jelszo ?>">

    <p><label>Telefonszám: <input type="text" name="telefon" placeholder="+40 740 123 456"></label></p>
    <p>
        <label>Lakhely:
            <select name="lakhely">
                <option value="Kolozsvár">Kolozsvár</option>
                <option value="Csíkszereda">Csíkszereda</option>
                <option value="Marosvásárhely">Marosvásárhely</option>
                <option value="Nagyvárad">Nagyvárad</option>
            </select>
        </label>
    </p>
    <p><label>Születési év: <input type="number" name="szuletesi_ev" min="1924" max="2006"></label></p>
    <button type="submit">Regisztráció befejezése</button>
</form>

</body>
</html>
