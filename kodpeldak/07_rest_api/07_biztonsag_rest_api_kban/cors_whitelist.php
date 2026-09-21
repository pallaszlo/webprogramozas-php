<?php

// =============================================================
// 7.20. Biztonságos CORS-konfiguráció (helpers.php)
// =============================================================

// CORS fejlécek beállítása whitelist alapján
function setCorsHeaders(array $allowedOrigins = []): void
{
    // Alapértelmezett engedélyezett domainek
    if (empty($allowedOrigins)) {
        $allowedOrigins = [
            'http://localhost:3000',
            'http://localhost:8080',
            'https://myapp.com',
            'https://www.myapp.com'
        ];
    }

    // Origin fejléc ellenőrzése
    $origin = $_SERVER['HTTP_ORIGIN'] ?? '';

    if (in_array($origin, $allowedOrigins, true)) {
        header("Access-Control-Allow-Origin: $origin");
    }

    // További CORS fejlécek
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
    header('Access-Control-Max-Age: 86400'); // 24 óra

    // Hitelesített kérések esetén:
    // header('Access-Control-Allow-Credentials: true');

    // Preflight kérés kezelése
    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        http_response_code(204);
        exit;
    }
}

// index.php:
setCorsHeaders([
    'http://localhost:3000',
    'https://myapp.com'
]);

// Kiegészítés (nem szerepel a könyvben): válasz a kipróbáláshoz
echo 'Origin: ' . ($_SERVER['HTTP_ORIGIN'] ?? '(nincs)');
