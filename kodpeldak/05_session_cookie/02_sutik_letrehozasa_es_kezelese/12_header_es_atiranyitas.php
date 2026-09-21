<?php

// =============================================================
// Kiegészítés: header() és átirányítás
// =============================================================
// Ez a példa nem szerepel a könyvben.

// Átirányítás bemutatása
// Ha az 'atiranyit' paraméter be van állítva, átirányítunk
if (isset($_GET['atiranyit'])) {
    header('Location: 12_header_es_atiranyitas.php?erkezes=1');
    exit; // a Location fejléc után ajánlott leállítani a szkriptet
}

$erkezes = isset($_GET['erkezes']);
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>header() és átirányítás</title>
</head>
<body>

<h1>header() függvény és átirányítás</h1>

<?php if ($erkezes): ?>
    <p style="color:green;">Sikeres átirányítás! (Az oldal GET-paraméterrel töltődött be.)</p>
<?php endif; ?>

<h2>Átirányítás tesztelése</h2>
<a href="?atiranyit=1">Kattintson ide az átirányítás kipróbálásához</a>

<h2>Egyéb header() használati esetek</h2>
<pre>
// Átirányítás
header("Location: masik_oldal.php");
exit;

// HTTP státuszkód
header("HTTP/1.1 404 Not Found");

// Gyorsítótárazás letiltása
header("Cache-Control: no-cache, must-revalidate");

// JSON válasz
header("Content-Type: application/json");

// Fájlletöltés
header("Content-Disposition: attachment; filename=riport.pdf");
</pre>

<h2>Headers already sent – kerülendő!</h2>
<pre>
// HELYTELEN: echo a header() előtt
echo "Hello!";
header("Location: masik.php"); // Hiba!

// HELYES: header() minden kimenet előtt
header("Location: masik.php");
exit;
echo "Ezt már nem látja senki";
</pre>

</body>
</html>
