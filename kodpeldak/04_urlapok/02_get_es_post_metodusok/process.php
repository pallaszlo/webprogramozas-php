<?php

// =============================================================
// 4.9. Külön feldolgozó fájl (process.php)
// =============================================================

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    // Feldolgozás...
}

// Kiegészítés (nem szerepel a könyvben): a feldolgozás eredményének kiírása
echo "<p>Feldolgozott felhasználónév: " . htmlspecialchars($username ?? '') . "</p>";
echo '<p><a href="01_get_post_urlapok.php">Vissza</a></p>';
