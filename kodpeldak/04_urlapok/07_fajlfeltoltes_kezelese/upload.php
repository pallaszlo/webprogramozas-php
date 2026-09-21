<?php

// =============================================================
// 4.37–4.38. Fájlfeltöltés feldolgozása (upload.php)
// =============================================================


// --- 4.37. $_FILES tömb használata ---------------------------

$file = $_FILES["fileToUpload"];
echo "Fájlnév: " . htmlspecialchars($file["name"]) . "<br>";
echo "Típus: "   . htmlspecialchars($file["type"]) . "<br>";
echo "Méret: "   . $file["size"] . " bytes<br>";
echo "Hibakód: " . $file["error"];


// --- 4.38. Biztonságos fájlfeltöltés -------------------------

$errors = [];
$file = $_FILES['fileToUpload'] ?? null;

if ($file === null || $file['error'] === UPLOAD_ERR_NO_FILE) {
    $errors[] = "Nem választottunk ki fájlt.";
} elseif ($file['error'] !== UPLOAD_ERR_OK) {
    $errors[] = "Feltöltési hiba (kód: {$file['error']}).";
} elseif (!is_uploaded_file($file['tmp_name'])) {
    // Ellenőrzés: a fájl valóban HTTP POST feltöltésből származik-e
    $errors[] = "Érvénytelen feltöltés.";
} else {
    // Kiterjesztés kinyerése: a pathinfo() a fájlnév részeit
    // (könyvtár, név, kiterjesztés) adja vissza
    $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    // Méret ellenőrzése (max 5MB)
    if ($file['size'] > 5 * 1024 * 1024) {
        $errors[] = "A fájl túl nagy.";
    }

    // Kiterjesztés ellenőrzése
    $allowedExtensions = ["jpg", "jpeg", "png", "gif", "pdf"];
    if (!in_array($extension, $allowedExtensions)) {
        $errors[] = "Nem engedélyezett fájltípus.";
    }

    // MIME típus ellenőrzése a fájl tartalma alapján
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($file['tmp_name']);
    $allowedMimes = ['image/jpeg', 'image/png', 'image/gif', 'application/pdf'];
    if (!in_array($mime, $allowedMimes)) {
        $errors[] = "Nem megengedett MIME típus.";
    }

    // Feltöltés biztonságos, véletlen fájlnévvel
    if (empty($errors)) {
        $safeFilename = bin2hex(random_bytes(16)) . '.' . $extension;
        if (!move_uploaded_file($file['tmp_name'], "uploads/" . $safeFilename)) {
            $errors[] = "A fájl mentése nem sikerült.";
        }
    }
}


// Kiegészítés (nem szerepel a könyvben): az eredmény kiírása
echo "<br>";
if (empty($errors)) {
    echo "Sikeres feltöltés: uploads/" . $safeFilename;
} else {
    foreach ($errors as $error) {
        echo htmlspecialchars($error) . "<br>";
    }
}
echo '<p><a href="01_feltolto_urlap.html">Vissza</a></p>';
