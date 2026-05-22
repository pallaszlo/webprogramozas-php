<?php
// cURL tesztelőkliens a Stocks API-hoz
// Futtatás előtt indítsd el az API szervert:
//   php -S localhost:8081 api/index.php

$baseUrl = 'http://localhost:8081/api';

function apiRequest(string $method, string $url, ?array $data = null, ?string $token = null): array
{
    $ch = curl_init();
    $headers = ['Content-Type: application/json'];
    if ($token) {
        $headers[] = "Authorization: Bearer $token";
    }
    curl_setopt_array($ch, [
        CURLOPT_URL            => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST  => $method,
        CURLOPT_HTTPHEADER     => $headers,
    ]);
    if ($data !== null) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    }
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return ['code' => $httpCode, 'body' => json_decode($response, true)];
}

function printResult(string $label, array $result): void
{
    $ok = $result['code'] >= 200 && $result['code'] < 300;
    echo ($ok ? "✓" : "✗") . " $label [HTTP {$result['code']}]\n";
    echo json_encode($result['body'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n\n";
}

echo "=== Stocks API – cURL teszt ===\n\n";

// 1. Szektorok listája
$r = apiRequest('GET', "$baseUrl/sectors");
printResult('GET /api/sectors', $r);

// 2. Részvények listája
$r = apiRequest('GET', "$baseUrl/stocks");
printResult('GET /api/stocks (lista)', $r);

// 3. Szűrés + rendezés + lapozás
$r = apiRequest('GET', "$baseUrl/stocks?sector=1&sort=price_asc&page=1&limit=3");
printResult('GET /api/stocks?sector=1&sort=price_asc&limit=3', $r);

// 4. Egyedi részvény
$r = apiRequest('GET', "$baseUrl/stocks/1");
printResult('GET /api/stocks/1', $r);

// 5. Nem létező részvény (404)
$r = apiRequest('GET', "$baseUrl/stocks/999");
printResult('GET /api/stocks/999 (404 elvárt)', $r);

// 6. Bejelentkezés
$r = apiRequest('POST', "$baseUrl/auth", ['email' => 'admin@example.com', 'password' => 'secret123']);
printResult('POST /api/auth (bejelentkezés)', $r);
$token = $r['body']['data']['token'] ?? null;

if (!$token) {
    echo "Token nem érkezett – a többi teszt kihagyva.\n";
    exit;
}
echo "Token: $token\n\n";

// 7. Hibás jelszó (401)
$r = apiRequest('POST', "$baseUrl/auth", ['email' => 'admin@example.com', 'password' => 'rossz']);
printResult('POST /api/auth hibás jelszó (401 elvárt)', $r);

// 8. Új részvény (tokennel)
$r = apiRequest('POST', "$baseUrl/stocks",
    ['ticker' => 'NVDA', 'company_name' => 'NVIDIA Corp.', 'sector_id' => 1, 'price' => 875.00],
    $token
);
printResult('POST /api/stocks (létrehozás)', $r);
$newId = $r['body']['data']['id'] ?? null;

// 9. Validációs hiba (422)
$r = apiRequest('POST', "$baseUrl/stocks",
    ['ticker' => 'X', 'company_name' => '', 'price' => -5],
    $token
);
printResult('POST /api/stocks validációs hiba (422 elvárt)', $r);

// 10. PATCH – csak ár módosítása
if ($newId) {
    $r = apiRequest('PATCH', "$baseUrl/stocks/$newId", ['price' => 920.50], $token);
    printResult("PATCH /api/stocks/$newId (ár frissítése)", $r);
}

// 11. PUT – teljes módosítás
if ($newId) {
    $r = apiRequest('PUT', "$baseUrl/stocks/$newId",
        ['ticker' => 'NVDA', 'company_name' => 'NVIDIA Corporation', 'sector_id' => 1, 'price' => 930.00],
        $token
    );
    printResult("PUT /api/stocks/$newId (teljes módosítás)", $r);
}

// 12. DELETE – törlés (204 No Content)
if ($newId) {
    $r = apiRequest('DELETE', "$baseUrl/stocks/$newId", null, $token);
    echo ($r['code'] === 204 ? "✓" : "✗") . " DELETE /api/stocks/$newId (törlés) [HTTP {$r['code']}]\n\n";
}

// 13. Token nélkül (401)
$r = apiRequest('POST', "$baseUrl/stocks",
    ['ticker' => 'TEST', 'company_name' => 'Test Corp', 'price' => 100]
);
printResult('POST /api/stocks token nélkül (401 elvárt)', $r);
