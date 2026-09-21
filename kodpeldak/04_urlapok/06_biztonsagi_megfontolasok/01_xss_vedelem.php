<?php

// =============================================================
// 4.33. XSS-védelem
// =============================================================

// Kiegészítés: a kód csak POST kérésnél fut (nem szerepel a könyvben)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

/* HELYTELEN - XSS-re sérülékeny */
echo "<p>Üdvözöljük, " . $_POST['name'] . "!</p>";

/* HELYES - biztonságos kimeneti kezelés */
echo "<p>Üdvözöljük, " . htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8') . "!</p>";
} // a kiegészítés vége
?>

<!-- Kiegészítés (nem szerepel a könyvben): űrlap a kipróbáláshoz.
     Próbáljuk ki ezzel a névvel: <b>Anna</b> -->
<form method="POST">
    <input type="text" name="name" placeholder="Név">
    <input type="submit" value="Küldés">
</form>
