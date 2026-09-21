<?php

// =============================================================
// Kiegészítés: a 4.23. kódpélda űrlapjának feldolgozója
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
    <p><a href="01_validacio.html">Vissza</a></p>
</body>
</html>
