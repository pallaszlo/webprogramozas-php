<?php
// cURL tesztelőkliens a Student API-hoz
// Futtatás előtt indítsd el az API szervert:
//   php -S localhost:8080 api/index.php

$baseUrl = 'http://localhost:8080/api';

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

    return [
        'code' => $httpCode,
        'body' => json_decode($response, true),
    ];
}

function printResult(string $label, array $result): void
{
    $ok = $result['code'] >= 200 && $result['code'] < 300;
    echo ($ok ? "✓" : "✗") . " $label [HTTP {$result['code']}]\n";
    echo json_encode($result['body'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n\n";
}

echo "=== Student API – cURL teszt ===\n\n";

// 1. API info
$r = apiRequest('GET', "$baseUrl/");
printResult('GET /api/ (API info)', $r);

// 2. Hallgatók listája
$r = apiRequest('GET', "$baseUrl/students");
printResult('GET /api/students (lista)', $r);

// 3. Egyedi hallgató
$r = apiRequest('GET', "$baseUrl/students/1");
printResult('GET /api/students/1', $r);

// 4. Nem létező hallgató
$r = apiRequest('GET', "$baseUrl/students/999");
printResult('GET /api/students/999 (404 elvárt)', $r);

// 5. Bejelentkezés – token lekérése
$r = apiRequest('POST', "$baseUrl/auth", ['email' => 'nagy.janos@example.com', 'password' => 'bármi']);
printResult('POST /api/auth (bejelentkezés)', $r);
$token = $r['body']['data']['token'] ?? null;

if (!$token) {
    echo "Token nem érkezett – a többi teszt kihagyva.\n";
    exit;
}
echo "Token: $token\n\n";

// 6. Új hallgató (tokennel)
$r = apiRequest('POST', "$baseUrl/students",
    ['name' => 'Szabó Gábor', 'email' => 'szabo.gabor@example.com'],
    $token
);
printResult('POST /api/students (létrehozás)', $r);
$newId = $r['body']['data']['id'] ?? null;

// 7. Módosítás
if ($newId) {
    $r = apiRequest('PUT', "$baseUrl/students/$newId",
        ['email' => 'szabo.gabor.uj@example.com'],
        $token
    );
    printResult("PUT /api/students/$newId (módosítás)", $r);
}

// 8. Törlés
if ($newId) {
    $r = apiRequest('DELETE', "$baseUrl/students/$newId", null, $token);
    printResult("DELETE /api/students/$newId (törlés)", $r);
}

// 9. Védett végpont token nélkül (401 elvárt)
$r = apiRequest('POST', "$baseUrl/students", ['name' => 'x', 'email' => 'x@x.com']);
printResult('POST /api/students token nélkül (401 elvárt)', $r);

// 10. Lapozás
$r = apiRequest('GET', "$baseUrl/students?page=1&limit=2&sort=name&order=ASC");
printResult('GET /api/students?page=1&limit=2&sort=name (lapozás)', $r);
