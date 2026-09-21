<?php

// =============================================================
// Kiegészítés: a 4.2–4.4. kódpéldák űrlapjainak feldolgozója
// =============================================================
// Ez a feldolgozó nem szerepel a könyvben: kiírja a kapott adatokat.
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Kapott adatok</title>
</head>
<body>
    <h1>Kapott adatok ($_POST)</h1>
    <pre><?= htmlspecialchars(print_r($_POST, true)) ?></pre>
    <p><a href="01_urlap_elemek.html">Vissza</a></p>
</body>
</html>
