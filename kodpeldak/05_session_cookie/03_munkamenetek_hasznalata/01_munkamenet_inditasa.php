<?php

// =============================================================
// 5.14. Munkamenet indítása
// =============================================================

session_start([
    'cookie_lifetime' => 3600,     // süti élettartama másodpercben
    'cookie_secure'   => true,     // csak HTTPS esetén
    'cookie_httponly' => true,     // JavaScript nem férhet hozzá
    'cookie_samesite' => 'Strict'  // CSRF védelem
]);
