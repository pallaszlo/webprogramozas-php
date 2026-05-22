<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: step1.php');
    exit;
}

$felhasznalonev = htmlspecialchars(trim($_POST['felhasznalonev'] ?? ''));
$email          = htmlspecialchars(trim($_POST['email']          ?? ''));
$jelszo         = htmlspecialchars(trim($_POST['jelszo']         ?? ''));

// Ha a 2. lépés adatai is beérkeztek, megjelenítjük az összesítést
if (isset($_POST['telefon'])) {
    $telefon      = htmlspecialchars(trim($_POST['telefon']      ?? ''));
    $lakhely      = htmlspecialchars(trim($_POST['lakhely']      ?? ''));
    $szuletesi_ev = (int) ($_POST['szuletesi_ev'] ?? 0);
    ?>
    <!DOCTYPE html>
    <html lang="hu">
    <head><meta charset="UTF-8"><title>Regisztráció kész</title></head>
    <body>
    <h1>Regisztráció – összesítés</h1>
    <p><strong>Felhasználónév:</strong> <?= $felhasznalonev ?></p>
    <p><strong>E-mail:</strong> <?= $email ?></p>
    <p><strong>Telefon:</strong> <?= $telefon ?></p>
    <p><strong>Lakhely:</strong> <?= $lakhely ?></p>
    <p><strong>Születési év:</strong> <?= $szuletesi_ev ?></p>
    <a href="step1.php">Újrakezdés</a>
    </body>
    </html>
    <?php
    exit;
}
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>2. lépés – További adatok</title>
</head>
<body>

<h1>Regisztráció – 2. lépés: További adatok</h1>

<form method="POST">
    <!-- Az 1. lépés adatai rejtett mezőkben -->
    <input type="hidden" name="felhasznalonev" value="<?= $felhasznalonev ?>">
    <input type="hidden" name="email"          value="<?= $email ?>">
    <input type="hidden" name="jelszo"         value="<?= $jelszo ?>">

    <p><label>Telefon: <input type="text" name="telefon"></label></p>
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
