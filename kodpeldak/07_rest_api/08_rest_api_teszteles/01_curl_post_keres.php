<?php

// =============================================================
// 7.21. cURL POST-kérés JSON-adatokkal
// =============================================================
// Futtatás előtt indítsuk el a 07_biztonsag_rest_api_kban mappából az API-t:
//   php -S localhost:8080 api/index.php
// A példában szereplő token nem valódi, ezért az API 401-es választ ad.

// Inicializálás
$ch = curl_init();

// Küldendő adatok
$data = [
    "name" => "Nagy Péter",
    "email" => "nagy.peter@example.com"
];

// cURL opciók beállítása
curl_setopt($ch, CURLOPT_URL, "http://localhost:8080/api/students");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: Bearer abc123xyz...'
]);

// Kérés végrehajtása
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

// Hibakezelés
if (curl_errno($ch)) {
    echo 'cURL hiba: ' . curl_error($ch);
} else {
    echo "HTTP kód: $httpCode\n";
    $result = json_decode($response, true);
    print_r($result);
}
