<?php

// =============================================================
// 5.22. Flash üzenet megjelenítése (index.php)
// =============================================================

session_start();
if (isset($_SESSION['flash'])) {
    echo '<div class="alert">'
        . htmlspecialchars($_SESSION['flash'])
        . '</div>';
    unset($_SESSION['flash']);
}

// Kiegészítés (nem szerepel a könyvben): a mentés kipróbálása
echo '<p><a href="save.php">Mentés (save.php)</a></p>';
