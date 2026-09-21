<?php

// =============================================================
// 4.10. Feldolgozás ugyanabban a fájlban
// =============================================================

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    // Feldolgozás...
}
?>
<form method="POST">
    <input type="text" name="username">
    <input type="submit" value="Küldés">
</form>
