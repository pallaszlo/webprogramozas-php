<?php

// =============================================================
// 3.15. Hibakezelés és kivételkezelés
// =============================================================


// --- 3.59. Hibajelentés beállítása ---------------------------
// Minden hiba megjelenítése (fejlesztési környezetben)
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Hibák naplózása (éles környezetben)
ini_set('log_errors', '1');
ini_set('error_log', '/path/to/error.log');
