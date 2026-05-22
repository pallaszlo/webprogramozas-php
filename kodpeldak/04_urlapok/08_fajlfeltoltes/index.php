<?php
$errors  = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['fajl'])) {
    $fajl = $_FILES['fajl'];

    // 1. Valódi HTTP POST feltöltés?
    if (!is_uploaded_file($fajl['tmp_name'])) {
        $errors[] = 'Érvénytelen feltöltés.';
    }

    // 2. Hibakód ellenőrzése
    if ($fajl['error'] !== UPLOAD_ERR_OK) {
        $errors[] = 'Feltöltési hiba: ' . $fajl['error'];
    }

    // 3. Méretkorlát (max 2 MB)
    if ($fajl['size'] > 2 * 1024 * 1024) {
        $errors[] = 'A fájl mérete meghaladja a 2 MB-ot.';
    }

    // 4. Kiterjesztés whitelist
    $ext = strtolower(pathinfo($fajl['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) {
        $errors[] = 'Nem engedélyezett kiterjesztés. Csak jpg, jpeg, png, gif fogadható el.';
    }

    // 5. MIME típus ellenőrzése a fájl tartalmából
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime  = $finfo->file($fajl['tmp_name']);
    if (!in_array($mime, ['image/jpeg', 'image/png', 'image/gif'])) {
        $errors[] = 'Nem megengedett MIME típus: ' . htmlspecialchars($mime);
    }

    if (empty($errors)) {
        $ujNev = bin2hex(random_bytes(16)) . '.' . $ext;
        $cel   = __DIR__ . '/uploads/' . $ujNev;
        if (move_uploaded_file($fajl['tmp_name'], $cel)) {
            $success = $ujNev;
        } else {
            $errors[] = 'Nem sikerült menteni a fájlt. Ellenőrizd az uploads/ mappa jogosultságait.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Fájlfeltöltés</title>
</head>
<body>

<h1>Képfeltöltés</h1>

<?php if (!empty($errors)): ?>
    <ul style="color:red;">
        <?php foreach ($errors as $hiba): ?>
            <li><?= htmlspecialchars($hiba) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<?php if ($success): ?>
    <p style="color:green;">Sikeres feltöltés!</p>
    <img src="uploads/<?= htmlspecialchars($success) ?>" alt="Feltöltött kép" style="max-width:300px;">
<?php endif; ?>

<form method="POST" enctype="multipart/form-data">
    <p>
        <label>Válassz képet (jpg, jpeg, png, gif – max 2 MB):
            <input type="file" name="fajl" accept="image/*">
        </label>
    </p>
    <button type="submit">Feltöltés</button>
</form>

</body>
</html>
