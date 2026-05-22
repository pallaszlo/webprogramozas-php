<?php
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
    if (empty($input)) {
        return [];
    }
    try {
        return json_decode($input, true, 512, JSON_THROW_ON_ERROR) ?? [];
    } catch (JsonException $e) {
        sendError('Érvénytelen JSON formátum', 400);
    }
}

// -----------------------------------------------------------------------
// Token kezelés (oktatási célú – éles környezetben használj JWT-t!)
// -----------------------------------------------------------------------

define('TOKEN_TTL', 86400); // 24 óra másodpercben

// Token generálása a felhasználó ID alapján
function generateToken(int $userId): string
{
    $timestamp = time();
    $data      = "$userId|$timestamp";
    $signature = hash_hmac('sha256', $data, $_ENV['SECRET_KEY'], true);

    return base64_encode($data) . '.' . base64_encode($signature);
}

// Token validálása – visszaadja a user ID-t, vagy null-t ha érvénytelen
function validateToken(string $token): ?int
{
    $parts = explode('.', $token);
    if (count($parts) !== 2) {
        return null;
    }

    [$encodedData, $encodedSig] = $parts;
    $data      = base64_decode($encodedData);
    $signature = base64_decode($encodedSig);

    // Aláírás ellenőrzése
    $expected = hash_hmac('sha256', $data, $_ENV['SECRET_KEY'], true);
    if (!hash_equals($expected, $signature)) {
        return null;
    }

    // Adatok kinyerése
    $dataParts = explode('|', $data);
    if (count($dataParts) !== 2) {
        return null;
    }

    [$userId, $timestamp] = $dataParts;

    // Lejárat ellenőrzése
    if (time() - (int)$timestamp > TOKEN_TTL) {
        return null;
    }

    return (int)$userId;
}

// Bearer token kinyerése az Authorization fejlécből
function getBearerToken(): ?string
{
    $authHeader = getallheaders()['Authorization']
        ?? $_SERVER['HTTP_AUTHORIZATION']
        ?? '';

    if (!preg_match('/^Bearer\s+(.+)$/i', $authHeader, $matches)) {
        return null;
    }

    return $matches[1];
}

// Hitelesítés megkövetelése – visszaadja a user ID-t, vagy 401-gyel leáll
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
