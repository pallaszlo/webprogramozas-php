<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/helpers.php';

// CORS (6. feladat: csak localhost:3000 forrásból)
setCorsHeaders();

$method   = $_SERVER['REQUEST_METHOD'];
$uri      = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri      = trim(str_replace('/api', '', $uri), '/');
$segments = explode('/', $uri);

$resource = $segments[0] ?? '';
$id       = isset($segments[1]) && $segments[1] !== '' ? $segments[1] : null;

$pdo = getDbConnection();

switch ($resource) {
    case 'stocks':
        handleStocks($pdo, $method, $id);
        break;

    case 'sectors':
        handleSectors($pdo, $method, $id);
        break;

    case 'auth':
        handleAuth($pdo, $method);
        break;

    case '':
        sendSuccess(['name' => 'Stocks API', 'version' => '1.0.0']);
        break;

    default:
        sendError('Az erőforrás nem található', 404);
}

// -----------------------------------------------------------------------
// Stocks routing
// -----------------------------------------------------------------------

function handleStocks(PDO $pdo, string $method, ?string $id): void
{
    switch ($method) {
        case 'GET':
            $id ? getStock($pdo, $id) : getStocks($pdo);
            break;

        case 'POST':
            requireAuth();
            if ($id) {
                sendError('Létrehozáshoz nem szükséges azonosító', 400);
            }
            createStock($pdo);
            break;

        case 'PUT':
            requireAuth();
            if (!$id) {
                sendError('Módosításhoz azonosító szükséges', 400);
            }
            updateStock($pdo, $id);
            break;

        case 'PATCH':
            requireAuth();
            if (!$id) {
                sendError('Azonosító szükséges', 400);
            }
            patchStockPrice($pdo, $id);
            break;

        case 'DELETE':
            requireAuth();
            if (!$id) {
                sendError('Törléshez azonosító szükséges', 400);
            }
            deleteStock($pdo, $id);
            break;

        default:
            sendError("A(z) $method metódus nem engedélyezett", 405);
    }
}

// -----------------------------------------------------------------------
// Stocks CRUD (4. feladat: szűrés, rendezés, lapozás)
// -----------------------------------------------------------------------

function getStocks(PDO $pdo): void
{
    $page   = max(1, (int)($_GET['page']  ?? 1));
    $limit  = min(100, max(1, (int)($_GET['limit'] ?? 10)));
    $offset = ($page - 1) * $limit;

    // Szűrés: szektor
    $sectorId   = isset($_GET['sector']) ? (int)$_GET['sector'] : null;
    $whereClause = $sectorId ? 'WHERE s.sector_id = :sector_id' : '';

    // Rendezés: ár szerint
    $sort = $_GET['sort'] ?? '';
    $orderClause = match($sort) {
        'price_asc'  => 'ORDER BY s.price ASC',
        'price_desc' => 'ORDER BY s.price DESC',
        default      => 'ORDER BY s.ticker ASC',
    };

    $sql = "SELECT s.id, s.ticker, s.company_name, s.price,
                   sec.name AS sector_name, s.created_at
            FROM stocks s
            LEFT JOIN sectors sec ON s.sector_id = sec.id
            $whereClause
            $orderClause
            LIMIT :limit OFFSET :offset";

    $params = [':limit' => $limit, ':offset' => $offset];
    if ($sectorId) {
        $params[':sector_id'] = $sectorId;
    }

    $countSql = "SELECT COUNT(*) FROM stocks s $whereClause";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':limit',  $limit,  PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        if ($sectorId) {
            $stmt->bindValue(':sector_id', $sectorId, PDO::PARAM_INT);
        }
        $stmt->execute();
        $stocks = $stmt->fetchAll();

        $countStmt = $pdo->prepare($countSql);
        if ($sectorId) {
            $countStmt->bindValue(':sector_id', $sectorId, PDO::PARAM_INT);
        }
        $countStmt->execute();
        $total = (int)$countStmt->fetchColumn();

        sendSuccess([
            'stocks'     => $stocks,
            'pagination' => [
                'page'  => $page,
                'limit' => $limit,
                'total' => $total,
                'pages' => (int)ceil($total / $limit),
            ],
        ]);
    } catch (PDOException $e) {
        sendError('Adatbázis hiba', 500);
    }
}

function getStock(PDO $pdo, string $id): void
{
    if (!is_numeric($id) || $id < 1) {
        sendError('Érvénytelen azonosító', 400);
    }

    try {
        $stmt = $pdo->prepare("SELECT s.*, sec.name AS sector_name
            FROM stocks s LEFT JOIN sectors sec ON s.sector_id = sec.id
            WHERE s.id = :id");
        $stmt->execute([':id' => $id]);
        $stock = $stmt->fetch();

        if (!$stock) {
            sendError('A részvény nem található', 404);
        }

        sendSuccess($stock);
    } catch (PDOException $e) {
        sendError('Adatbázis hiba', 500);
    }
}

function createStock(PDO $pdo): void
{
    $input = getJsonInput();

    $errors = [];
    if (empty($input['ticker'])) {
        $errors['ticker'] = 'A ticker megadása kötelező';
    } elseif (!preg_match('/^[A-Z]{1,10}$/', strtoupper($input['ticker']))) {
        $errors['ticker'] = 'A ticker csak nagybetűket tartalmazhat (max. 10 karakter)';
    }
    if (empty($input['company_name'])) {
        $errors['company_name'] = 'A vállalat neve kötelező';
    }
    if (!isset($input['price']) || !is_numeric($input['price']) || $input['price'] <= 0) {
        $errors['price'] = 'Az ár pozitív szám kell legyen';
    }

    if (!empty($errors)) {
        sendError('Validációs hiba', 422, $errors);
    }

    $ticker      = strtoupper(trim($input['ticker']));
    $companyName = trim($input['company_name']);
    $price       = (float)$input['price'];
    $sectorId    = isset($input['sector_id']) ? (int)$input['sector_id'] : null;

    try {
        $stmt = $pdo->prepare("INSERT INTO stocks (ticker, company_name, sector_id, price)
                               VALUES (:ticker, :company_name, :sector_id, :price)");
        $stmt->execute([
            ':ticker'       => $ticker,
            ':company_name' => $companyName,
            ':sector_id'    => $sectorId,
            ':price'        => $price,
        ]);

        $newId = $pdo->lastInsertId();
        $stmt  = $pdo->prepare("SELECT * FROM stocks WHERE id = :id");
        $stmt->execute([':id' => $newId]);

        sendSuccess($stmt->fetch(), 'Részvény sikeresen létrehozva', 201);
    } catch (PDOException $e) {
        if ($e->getCode() === '23000') {
            sendError('Ez a ticker már létezik', 409);
        }
        sendError('Adatbázis hiba', 500);
    }
}

function updateStock(PDO $pdo, string $id): void
{
    if (!is_numeric($id) || $id < 1) {
        sendError('Érvénytelen azonosító', 400);
    }

    $check = $pdo->prepare("SELECT id FROM stocks WHERE id = :id");
    $check->execute([':id' => $id]);
    if (!$check->fetch()) {
        sendError('A részvény nem található', 404);
    }

    $input = getJsonInput();

    $errors = [];
    if (empty($input['ticker'])) {
        $errors['ticker'] = 'A ticker kötelező';
    }
    if (empty($input['company_name'])) {
        $errors['company_name'] = 'A vállalat neve kötelező';
    }
    if (!isset($input['price']) || !is_numeric($input['price']) || $input['price'] <= 0) {
        $errors['price'] = 'Az ár pozitív szám kell legyen';
    }
    if (!empty($errors)) {
        sendError('Validációs hiba', 422, $errors);
    }

    try {
        $stmt = $pdo->prepare("UPDATE stocks SET ticker = :ticker, company_name = :company_name,
                               sector_id = :sector_id, price = :price WHERE id = :id");
        $stmt->execute([
            ':ticker'       => strtoupper(trim($input['ticker'])),
            ':company_name' => trim($input['company_name']),
            ':sector_id'    => isset($input['sector_id']) ? (int)$input['sector_id'] : null,
            ':price'        => (float)$input['price'],
            ':id'           => $id,
        ]);

        $stmt = $pdo->prepare("SELECT * FROM stocks WHERE id = :id");
        $stmt->execute([':id' => $id]);
        sendSuccess($stmt->fetch(), 'Részvény sikeresen módosítva');
    } catch (PDOException $e) {
        if ($e->getCode() === '23000') {
            sendError('Ez a ticker már létezik', 409);
        }
        sendError('Adatbázis hiba', 500);
    }
}

function patchStockPrice(PDO $pdo, string $id): void
{
    if (!is_numeric($id) || $id < 1) {
        sendError('Érvénytelen azonosító', 400);
    }

    $input = getJsonInput();
    if (!isset($input['price']) || !is_numeric($input['price']) || $input['price'] <= 0) {
        sendError('Az ár pozitív szám kell legyen', 422, ['price' => 'pozitív szám szükséges']);
    }

    try {
        $stmt = $pdo->prepare("UPDATE stocks SET price = :price WHERE id = :id");
        $stmt->execute([':price' => (float)$input['price'], ':id' => $id]);

        if ($stmt->rowCount() === 0) {
            sendError('A részvény nem található', 404);
        }

        $stmt = $pdo->prepare("SELECT * FROM stocks WHERE id = :id");
        $stmt->execute([':id' => $id]);
        sendSuccess($stmt->fetch(), 'Ár sikeresen frissítve');
    } catch (PDOException $e) {
        sendError('Adatbázis hiba', 500);
    }
}

function deleteStock(PDO $pdo, string $id): void
{
    if (!is_numeric($id) || $id < 1) {
        sendError('Érvénytelen azonosító', 400);
    }

    try {
        $stmt = $pdo->prepare("SELECT * FROM stocks WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $stock = $stmt->fetch();

        if (!$stock) {
            sendError('A részvény nem található', 404);
        }

        $pdo->prepare("DELETE FROM stocks WHERE id = :id")->execute([':id' => $id]);
        http_response_code(204);
        exit;
    } catch (PDOException $e) {
        sendError('Adatbázis hiba', 500);
    }
}

// -----------------------------------------------------------------------
// Sectors (csak olvasás)
// -----------------------------------------------------------------------

function handleSectors(PDO $pdo, string $method, ?string $id): void
{
    if ($method !== 'GET') {
        sendError("A(z) $method metódus nem engedélyezett", 405);
    }

    try {
        if ($id) {
            if (!is_numeric($id)) {
                sendError('Érvénytelen azonosító', 400);
            }
            $stmt = $pdo->prepare("SELECT * FROM sectors WHERE id = :id");
            $stmt->execute([':id' => $id]);
            $sector = $stmt->fetch();
            $sector ? sendSuccess($sector) : sendError('A szektor nem található', 404);
        } else {
            $sectors = $pdo->query("SELECT * FROM sectors ORDER BY name")->fetchAll();
            sendSuccess($sectors);
        }
    } catch (PDOException $e) {
        sendError('Adatbázis hiba', 500);
    }
}

// -----------------------------------------------------------------------
// Hitelesítés (5. feladat: Bearer token)
// -----------------------------------------------------------------------

function handleAuth(PDO $pdo, string $method): void
{
    if ($method !== 'POST') {
        sendError('A metódus nem engedélyezett', 405);
    }

    $input = getJsonInput();

    if (!isset($input['email'], $input['password'])) {
        sendError('E-mail cím és jelszó megadása kötelező', 400);
    }

    try {
        $stmt = $pdo->prepare("SELECT id, email, password FROM users WHERE email = :email LIMIT 1");
        $stmt->execute([':email' => trim($input['email'])]);
        $user = $stmt->fetch();

        if (!$user || !password_verify($input['password'], $user['password'])) {
            sendError('Hibás e-mail cím vagy jelszó', 401);
        }

        sendSuccess([
            'token' => generateToken($user['id']),
            'user'  => ['id' => $user['id'], 'email' => $user['email']],
        ], 'Sikeres bejelentkezés');

    } catch (PDOException $e) {
        sendError('Adatbázis hiba', 500);
    }
}
