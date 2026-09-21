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
