<?php
// 2. feladat: részvénylista adatbázis nélkül, tömbből kiszolgálva.
// Indítás ebből a mappából:
//   php -S localhost:8082 index.php
// Kipróbálás: http://localhost:8082/api/stocks és http://localhost:8082/api/stocks/2

$stocks = [
    ['id' => 1, 'ticker' => 'AAPL',  'company_name' => 'Apple Inc.',        'price' => 189.30],
    ['id' => 2, 'ticker' => 'MSFT',  'company_name' => 'Microsoft Corp.',   'price' => 415.50],
    ['id' => 3, 'ticker' => 'GOOGL', 'company_name' => 'Alphabet Inc.',     'price' => 175.20],
    ['id' => 4, 'ticker' => 'JPM',   'company_name' => 'JPMorgan Chase',    'price' => 198.40],
    ['id' => 5, 'ticker' => 'JNJ',   'company_name' => 'Johnson & Johnson', 'price' => 147.80],
];

function sendJson(array $data, int $statusCode = 200): void
{
    http_response_code($statusCode);
    header('Content-Type: application/json; charset=UTF-8');
    echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    exit;
}

// Az útvonal szegmensei: /api/stocks/2 -> ['api', 'stocks', '2']
$path     = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$segments = explode('/', $path);

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    sendJson(['status' => 'error', 'message' => 'Csak GET kérés engedélyezett'], 405);
}

if (($segments[0] ?? '') !== 'api' || ($segments[1] ?? '') !== 'stocks') {
    sendJson(['status' => 'error', 'message' => 'Az erőforrás nem található'], 404);
}

$id = $segments[2] ?? null;

// GET /api/stocks
if ($id === null || $id === '') {
    sendJson(['status' => 'success', 'data' => $stocks]);
}

// GET /api/stocks/{id}
foreach ($stocks as $stock) {
    if ((string)$stock['id'] === $id) {
        sendJson(['status' => 'success', 'data' => $stock]);
    }
}

sendJson(['status' => 'error', 'message' => 'A részvény nem található'], 404);
