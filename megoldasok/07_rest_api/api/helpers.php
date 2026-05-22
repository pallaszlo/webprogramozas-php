<?php
define('TOKEN_TTL', 86400);

function sendJson(mixed $data, int $statusCode = 200): void
{
    http_response_code($statusCode);
    header('Content-Type: application/json; charset=UTF-8');
    echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR);
    exit;
}

function sendSuccess(mixed $data, string $message = 'Sikeres', int $statusCode = 200): void
{
    sendJson(['status' => 'success', 'message' => $message, 'data' => $data], $statusCode);
}

function sendError(string $message, int $statusCode = 400, ?array $errors = null): void
{
    $response = ['status' => 'error', 'message' => $message];
    if ($errors !== null) {
        $response['errors'] = $errors;
    }
    sendJson($response, $statusCode);
}

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

function generateToken(int $userId): string
{
    $data      = "$userId|" . time();
    $signature = hash_hmac('sha256', $data, $_ENV['SECRET_KEY'], true);
    return base64_encode($data) . '.' . base64_encode($signature);
}

function validateToken(string $token): ?int
{
    $parts = explode('.', $token);
    if (count($parts) !== 2) {
        return null;
    }

    $data      = base64_decode($parts[0]);
    $signature = base64_decode($parts[1]);

    if (!hash_equals(hash_hmac('sha256', $data, $_ENV['SECRET_KEY'], true), $signature)) {
        return null;
    }

    $dataParts = explode('|', $data);
    if (count($dataParts) !== 2) {
        return null;
    }

    [$userId, $timestamp] = $dataParts;
    if (time() - (int)$timestamp > TOKEN_TTL) {
        return null;
    }

    return (int)$userId;
}

function getBearerToken(): ?string
{
    $auth = getallheaders()['Authorization'] ?? $_SERVER['HTTP_AUTHORIZATION'] ?? '';
    if (!preg_match('/^Bearer\s+(.+)$/i', $auth, $m)) {
        return null;
    }
    return $m[1];
}

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

// CORS fejlécek beállítása (whitelist alapon)
function setCorsHeaders(): void
{
    $allowedOrigins = ['http://localhost:3000', 'http://localhost:8080'];
    $origin = $_SERVER['HTTP_ORIGIN'] ?? '';

    if (in_array($origin, $allowedOrigins)) {
        header("Access-Control-Allow-Origin: $origin");
    }
    header('Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Authorization');
    header('Access-Control-Max-Age: 86400');

    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        http_response_code(204);
        exit;
    }
}
