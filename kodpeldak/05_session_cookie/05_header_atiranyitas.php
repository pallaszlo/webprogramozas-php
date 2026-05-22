<?php
// Átirányítás demonstrálása
// Ha az 'atiranyit' paraméter be van állítva, átirányítunk
if (isset($_GET['atiranyit'])) {
    header('Location: 05_header_atiranyitas.php?erkezes=1');
    exit; // Mindig exit a header() után!
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
    <p style="color:green;">Sikeres átirányítás! (GET paraméterrel érkeztél ide.)</p>
<?php endif; ?>

<h2>Átirányítás tesztelése</h2>
<a href="?atiranyit=1">Kattints ide az átirányítás teszteléséhez</a>

<h2>Egyéb header() használati esetek</h2>
<pre>
// Átirányítás
header("Location: masik_oldal.php");
exit;

// HTTP státuszkód
header("HTTP/1.1 404 Not Found");

// Cache letiltása
header("Cache-Control: no-cache, must-revalidate");

// JSON válasz
header("Content-Type: application/json");

// Fájl letöltés
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
