<?php

// =============================================================
// 4.11. A PHP- és HTML-kód keveredése
// =============================================================

if ($_SERVER['REQUEST_METHOD'] === 'GET') : ?>
    <!-- Űrlap megjelenítése -->
<?php else : ?>
    <!-- Feldolgozás eredménye -->
<?php endif; ?>
