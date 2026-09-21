<?php

// =============================================================
// 5.8. CSRF elleni védelem SameSite attribútummal
// =============================================================

// Előkészítés a futtatáshoz (nem része a könyvbeli kódpéldának)
$sessionId = bin2hex(random_bytes(16));

// Bejelentkezési süti CSRF védelemmel
setcookie("session_id", $sessionId, [
    'expires'  => time() + 3600,
    'path'     => '/',
    'secure'   => true,
    'httponly' => true,
    'samesite' => 'Strict'  // Csak saját domainről érkező kérések
]);
