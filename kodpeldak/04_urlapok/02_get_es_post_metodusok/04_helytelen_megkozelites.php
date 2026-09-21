<?php

// =============================================================
// 4.12. Helytelen megközelítés (dupla beküldés lehetséges)
// =============================================================

// HELYTELEN - dupla beküldés lehetséges!
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    // Adatok mentése adatbázisba...
    echo "Sikeres mentés!"; // F5 esetén újra lefut!
}
?>
<form method="POST">
    <input type="text" name="name">
    <input type="submit" value="Küldés">
</form>
