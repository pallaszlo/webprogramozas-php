<?php
$errors  = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profilkep'])) {
    $fajl = $_FILES['profilkep'];

    // 1. Valódi HTTP POST feltöltés ellenőrzése
    if (!is_uploaded_file($fajl['tmp_name'])) {
        $errors[] = 'Érvénytelen feltöltés.';
    }

    // 2. Hibakód ellenőrzése
    if ($fajl['error'] !== UPLOAD_ERR_OK) {
        $hibakodok = [
            UPLOAD_ERR_INI_SIZE   => 'A fájl meghaladja a szerver által engedélyezett méretet.',
            UPLOAD_ERR_FORM_SIZE  => 'A fájl meghaladja az űrlapban megadott méretet.',
            UPLOAD_ERR_PARTIAL    => 'A fájl csak részben töltődött fel.',
            UPLOAD_ERR_NO_FILE    => 'Nem választottak fájlt.',
            UPLOAD_ERR_NO_TMP_DIR => 'Hiányzik az ideiglenes mappa.',
            UPLOAD_ERR_CANT_WRITE => 'Nem sikerült a lemezre írni.',
        ];
        $errors[] = $hibakodok[$fajl['error']] ?? 'Ismeretlen feltöltési hiba.';
    }

    // 3. Méretkorlát: maximum 2 MB
    if ($fajl['size'] > 2 * 1024 * 1024) {
        $errors[] = 'A fájl mérete meghaladja a 2 MB-ot.';
    }

    // 4. Kiterjesztés whitelist
    $ext = strtolower(pathinfo($fajl['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, ['jpg', 'jpeg', 'png'])) {
        $errors[] = 'Csak jpg, jpeg és png fájlok engedélyezettek.';
    }

    // 5. MIME típus ellenőrzése a fájl tartalmából
    if (empty($errors)) {
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime  = $finfo->file($fajl['tmp_name']);
        if (!in_array($mime, ['image/jpeg', 'image/png'])) {
            $errors[] = 'Nem megengedett MIME típus: ' . htmlspecialchars($mime);
        }
    }

    // Mentés
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
    <title>Profilkép-feltöltés</title>
</head>
<body>

<h1>Profilkép feltöltése</h1>

<?php if (!empty($errors)): ?>
    <ul style="color:red;">
        <?php foreach ($errors as $hiba): ?>
            <li><?= htmlspecialchars($hiba) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<?php if ($success): ?>
    <p style="color:green;">Sikeres feltöltés!</p>
    <img src="uploads/<?= htmlspecialchars($success) ?>"
         alt="Profilkép" style="max-width:200px; border-radius:50%;">
<?php endif; ?>

<form method="POST" enctype="multipart/form-data">
    <p>
        <label>Profilkép (jpg, jpeg, png – max 2 MB):
            <input type="file" name="profilkep" accept="image/jpeg,image/png">
        </label>
    </p>
    <button type="submit">Feltöltés</button>
</form>

</body>
</html>
