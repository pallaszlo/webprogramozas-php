<?php

// =============================================================
// 7.8. Segédfüggvények (helpers.php)
// =============================================================

// JSON válasz küldése
function sendJson(mixed $data, int $statusCode = 200): void
{
    http_response_code($statusCode);
    header('Content-Type: application/json; charset=UTF-8');
    echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR);
    exit;
}

// Sikeres válasz küldése
function sendSuccess(mixed $data, string $message = 'Sikeres', int $statusCode = 200): void
{
    sendJson(['status' => 'success', 'message' => $message, 'data' => $data], $statusCode);
}

// Hibaválasz küldése
function sendError(string $message, int $statusCode = 400, ?array $errors = null): void
{
    $response = ['status' => 'error', 'message' => $message];
    if ($errors !== null) {
        $response['errors'] = $errors;
    }
    sendJson($response, $statusCode);
}

// HTTP metódus ellenőrzése
function requireMethod(string $method): void
{
    if ($_SERVER['REQUEST_METHOD'] !== $method) {
        sendError("A(z) $method metódus nem engedélyezett", 405);
    }
}

// JSON input beolvasása és dekódolása
function getJsonInput(): array
{
    $input = file_get_contents('php://input');
    if (empty($input)) return [];
    try {
        $data = json_decode($input, true, 512, JSON_THROW_ON_ERROR);
        return is_array($data) ? $data : [];
    } catch (JsonException $e) {
        sendError('Érvénytelen JSON formátum', 400);
    }
}


// --- 7.16. Tokenkezelés (helpers.php) ------------------------

// A titkos kulcs éles környezetben .env fájlból érkezik (lásd a 8. fejezetet)
$_ENV['SECRET_KEY'] ??= 'csereljuk-le-egy-hosszu-veletlen-kulcsra';

// Egyszerű token generálás - FIGYELEM: Éles környezetben használjunk JWT-t!
function generateToken(int $userId): string
{
    $timestamp = time();
    $data = "$userId|$timestamp";

    // Token = base64(data) . '.' . base64(hmac(data))
    $signature = hash_hmac('sha256', $data, $_ENV['SECRET_KEY'], true);

    return base64_encode($data) . '.' . base64_encode($signature);
}

// Token validálás - visszaadja a user ID-t, vagy null-t ha érvénytelen
function validateToken(string $token): ?int
{
    $parts = explode('.', $token);

    if (count($parts) !== 2) {
        return null;
    }

    [$data, $signature] = $parts;
    $data = base64_decode($data);
    $signature = base64_decode($signature);

    // Signature ellenőrzés
    $expectedSignature = hash_hmac('sha256', $data, $_ENV['SECRET_KEY'], true);

    if (!hash_equals($expectedSignature, $signature)) {
        return null;
    }

    // Adatok kinyerése
    $parts = explode('|', $data);
    if (count($parts) !== 2) {
        return null;
    }

    [$userId, $timestamp] = $parts;

    // Token lejárat ellenőrzése (24 óra)
    if (time() - $timestamp > 86400) {
        return null;
    }

    return (int)$userId;
}

// Authorization header beolvasása, Bearer token kinyerése
function getBearerToken(): ?string
{
    // getallheaders() Apache alatt működik; Nginx/PHP-FPM esetén a $_SERVER a megbízható
    $authHeader = getallheaders()['Authorization'] ?? $_SERVER['HTTP_AUTHORIZATION'] ?? '';

    if (empty($authHeader)) {
        return null;
    }

    // Elvárt formátum: "Bearer abc123xyz..."
    if (!preg_match('/^Bearer\s+(.+)$/i', $authHeader, $matches)) {
        return null;
    }

    return $matches[1];
}

// Hitelesítés megkövetelése - visszaadja a user ID-t, vagy hibával leáll
function requireAuth(): int
{
    $token = getBearerToken();

    if (!$token) {
        sendError('Hitelesítési token szükséges', 401);
    }

    $userId = validateToken($token);

    if (!$userId) {
        sendError('Érvénytelen vagy lejárt token', 401);
    }

    return $userId;
}
