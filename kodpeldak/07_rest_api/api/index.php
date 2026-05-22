<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/helpers.php';

// CORS fejlécek
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Preflight kérés kezelése
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

// HTTP metódus és URI
$method = $_SERVER['REQUEST_METHOD'];
$uri    = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// /api prefix eltávolítása
$uri      = str_replace('/api', '', $uri);
$uri      = trim($uri, '/');
$segments = explode('/', $uri);

$resource = $segments[0] ?? '';
$id       = isset($segments[1]) && $segments[1] !== '' ? $segments[1] : null;

// Adatbázis kapcsolat
$pdo = getDbConnection();

// Routing
switch ($resource) {
    case 'students':
        handleStudents($pdo, $method, $id);
        break;

    case 'auth':
        handleAuth($pdo, $method);
        break;

    case '':
        sendSuccess([
            'name'      => 'Student API',
            'version'   => '1.0.0',
            'endpoints' => [
                'GET /api/students'        => 'Hallgatók listája',
                'GET /api/students/{id}'   => 'Hallgató lekérése azonosító alapján',
                'POST /api/students'       => 'Új hallgató létrehozása',
                'PUT /api/students/{id}'   => 'Hallgató módosítása',
                'DELETE /api/students/{id}'=> 'Hallgató törlése',
                'POST /api/auth'           => 'Bejelentkezés (token lekérése)',
            ],
        ]);
        break;

    default:
        sendError('Az erőforrás nem található', 404);
}

// -----------------------------------------------------------------------
// Routing: hallgatók
// -----------------------------------------------------------------------

function handleStudents(PDO $pdo, string $method, ?string $id): void
{
    switch ($method) {
        case 'GET':
            $id ? getStudent($pdo, $id) : getStudents($pdo);
            break;

        case 'POST':
            if ($id) {
                sendError('Létrehozáshoz nem szükséges azonosító', 400);
            }
            requireAuth();
            createStudent($pdo);
            break;

        case 'PUT':
            if (!$id) {
                sendError('Módosításhoz azonosító szükséges', 400);
            }
            requireAuth();
            updateStudent($pdo, $id);
            break;

        case 'DELETE':
            if (!$id) {
                sendError('Törléshez azonosító szükséges', 400);
            }
            requireAuth();
            deleteStudent($pdo, $id);
            break;

        default:
            sendError("A(z) $method metódus nem engedélyezett", 405);
    }
}

// -----------------------------------------------------------------------
// CRUD műveletek
// -----------------------------------------------------------------------

function getStudents(PDO $pdo): void
{
    $page  = max(1, (int)($_GET['page']  ?? 1));
    $limit = min(100, max(1, (int)($_GET['limit'] ?? 10)));
    $sort  = $_GET['sort']  ?? 'name';
    $order = strtoupper($_GET['order'] ?? 'ASC');

    $allowedSorts = ['name', 'email', 'created_at'];
    if (!in_array($sort, $allowedSorts)) {
        $sort = 'name';
    }
    if (!in_array($order, ['ASC', 'DESC'])) {
        $order = 'ASC';
    }

    $offset = ($page - 1) * $limit;

    try {
        $stmt = $pdo->prepare(
            "SELECT * FROM students ORDER BY $sort $order LIMIT :limit OFFSET :offset"
        );
        $stmt->bindValue(':limit',  $limit,  PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $students = $stmt->fetchAll();

        $total = (int)$pdo->query("SELECT COUNT(*) FROM students")->fetchColumn();

        sendSuccess([
            'students'   => $students,
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

function getStudent(PDO $pdo, string $id): void
{
    if (!is_numeric($id) || $id < 1) {
        sendError('Érvénytelen azonosító formátum', 400);
    }

    try {
        $stmt = $pdo->prepare("SELECT * FROM students WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $student = $stmt->fetch();

        if (!$student) {
            sendError('A hallgató nem található', 404);
        }

        sendSuccess($student);
    } catch (PDOException $e) {
        sendError('Adatbázis hiba', 500);
    }
}

function createStudent(PDO $pdo): void
{
    $input = getJsonInput();

    if (empty($input['name']) || empty($input['email'])) {
        sendError('Hiányzó kötelező mezők: name, email', 400);
    }

    $name  = trim($input['name']);
    $email = trim($input['email']);

    $errors = [];
    if (strlen($name) < 2 || strlen($name) > 100) {
        $errors['name'] = 'A névnek 2–100 karakter között kell lennie';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Érvénytelen e-mail formátum';
    }
    if (!empty($errors)) {
        sendError('Validációs hiba', 422, $errors);
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO students (name, email) VALUES (:name, :email)");
        $stmt->execute([':name' => $name, ':email' => $email]);

        $id   = $pdo->lastInsertId();
        $stmt = $pdo->prepare("SELECT * FROM students WHERE id = :id");
        $stmt->execute([':id' => $id]);

        sendSuccess($stmt->fetch(), 'Hallgató sikeresen létrehozva', 201);
    } catch (PDOException $e) {
        if ($e->getCode() === '23000') {
            sendError('Ez az e-mail cím már foglalt', 409);
        }
        sendError('Adatbázis hiba', 500);
    }
}

function updateStudent(PDO $pdo, string $id): void
{
    if (!is_numeric($id) || $id < 1) {
        sendError('Érvénytelen azonosító formátum', 400);
    }

    $checkStmt = $pdo->prepare("SELECT id FROM students WHERE id = :id");
    $checkStmt->execute([':id' => $id]);
    if (!$checkStmt->fetch()) {
        sendError('A hallgató nem található', 404);
    }

    $input = getJsonInput();
    if (empty($input)) {
        sendError('Nem érkezett frissítendő adat', 400);
    }

    $allowedFields = ['name', 'email'];
    $updateFields  = [];
    $params        = [':id' => $id];

    foreach ($input as $field => $value) {
        if (!in_array($field, $allowedFields)) {
            continue;
        }
        $updateFields[]    = "$field = :$field";
        $params[":$field"] = $value;
    }

    if (empty($updateFields)) {
        sendError('Nincs érvényes mező a frissítéshez', 400);
    }

    try {
        $sql = "UPDATE students SET " . implode(', ', $updateFields) . " WHERE id = :id";
        $pdo->prepare($sql)->execute($params);

        $stmt = $pdo->prepare("SELECT * FROM students WHERE id = :id");
        $stmt->execute([':id' => $id]);

        sendSuccess($stmt->fetch(), 'Hallgató sikeresen módosítva');
    } catch (PDOException $e) {
        if ($e->getCode() === '23000') {
            sendError('Ez az e-mail cím már foglalt', 409);
        }
        sendError('Adatbázis hiba', 500);
    }
}

function deleteStudent(PDO $pdo, string $id): void
{
    if (!is_numeric($id) || $id < 1) {
        sendError('Érvénytelen azonosító formátum', 400);
    }

    try {
        $checkStmt = $pdo->prepare("SELECT * FROM students WHERE id = :id");
        $checkStmt->execute([':id' => $id]);
        $student = $checkStmt->fetch();

        if (!$student) {
            sendError('A hallgató nem található', 404);
        }

        $pdo->prepare("DELETE FROM students WHERE id = :id")->execute([':id' => $id]);

        sendSuccess($student, 'Hallgató sikeresen törölve');
    } catch (PDOException $e) {
        sendError('Adatbázis hiba', 500);
    }
}

// -----------------------------------------------------------------------
// Hitelesítés
// -----------------------------------------------------------------------

function handleAuth(PDO $pdo, string $method): void
{
    if ($method !== 'POST') {
        sendError('A metódus nem engedélyezett', 405);
    }
    login($pdo);
}

function login(PDO $pdo): void
{
    $input = getJsonInput();

    if (!isset($input['email'])) {
        sendError('E-mail cím megadása kötelező', 400);
    }

    $email = trim($input['email']);

    try {
        // Demonstrációs célból a students táblából keresünk
        // Valós alkalmazásban users tábla + password_verify() szükséges
        $stmt = $pdo->prepare("SELECT id, name, email FROM students WHERE email = :email LIMIT 1");
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch();

        if (!$user) {
            sendError('Hibás e-mail cím vagy jelszó', 401);
        }

        $token = generateToken($user['id']);

        sendSuccess([
            'token' => $token,
            'user'  => [
                'id'    => $user['id'],
                'name'  => $user['name'],
                'email' => $user['email'],
            ],
        ], 'Sikeres bejelentkezés');

    } catch (PDOException $e) {
        sendError('Adatbázis hiba', 500);
    }
}
