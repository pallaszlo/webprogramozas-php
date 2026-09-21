<?php

// =============================================================
// 5.18. A munkamenet-azonosító újragenerálása bejelentkezés után
// =============================================================

// Előkészítés a futtatáshoz (nem része a könyvbeli kódpéldának)
$validLogin = true;
$felhasznaloId = 42;

session_start([
    'use_strict_mode' => true,     // Session fixation elleni védelem
    'use_only_cookies' => true,    // Session ID ne URL-ben legyen
    'cookie_secure' => true,       // Csak HTTPS
    'cookie_httponly' => true,     // XSS elleni védelem
    'cookie_samesite' => 'Strict'  // CSRF elleni védelem
]);

// Sikeres bejelentkezés után
if ($validLogin) {
    // Új session ID generálása (régi törlésével)
    session_regenerate_id(true);

    $_SESSION['felhasznalo_id'] = $felhasznaloId;
    $_SESSION['bejelentkezve']  = true;
}
