<?php

// =============================================================
// 7.9. Front controller (index.php)
// =============================================================

// Fájlok betöltése
require_once 'config.php';
require_once 'helpers.php';

// CORS fejlécek beállítása (később részletesen)
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Preflight kérés kezelése
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

// HTTP metódus és URI lekérése
$method = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// API prefix eltávolítása: /api/students helyett /students
$uri = str_replace('/api', '', $uri);
$uri = trim($uri, '/');

// URI szegmensekre bontása
$segments = explode('/', $uri);

// Routing logika
$resource = $segments[0] ?? '';
$id = $segments[1] ?? null;

// Adatbázis kapcsolat
$pdo = getDbConnection();

// Routing táblázat
switch ($resource) {
    case 'students':
        handleStudents($pdo, $method, $id);
        break;

    case '':
        // API info endpoint
        sendSuccess([
            'name' => 'Student API',
            'version' => '1.0.0',
            'endpoints' => [
                'GET /api/students' => 'Hallgatók listája',
                'GET /api/students/{id}' => 'Hallgató lekérése azonosító alapján',
                'POST /api/students' => 'Új hallgató létrehozása',
                'PUT /api/students/{id}' => 'Hallgató módosítása',
                'DELETE /api/students/{id}' => 'Hallgató törlése'
            ]
        ]);
        break;

    default:
        sendError('Az erőforrás nem található', 404);
}


// --- 7.10. Metódusalapú routing ------------------------------

function handleStudents(PDO $pdo, string $method, ?string $id): void
{
    switch ($method) {
        case 'GET':
            if ($id) {
                // GET /api/students/{id} - Egyedi hallgató lekérése
                getStudent($pdo, $id);
            } else {
                // GET /api/students - Lista lekérése
                getStudents($pdo);
            }
            break;

        case 'POST':
            // POST /api/students - Új hallgató létrehozása
            if ($id) {
                sendError('Létrehozáshoz nem szükséges azonosító', 400);
            }
            createStudent($pdo);
            break;

        case 'PUT':
            // PUT /api/students/{id} - Hallgató módosítása
            if (!$id) {
                sendError('Módosításhoz azonosító szükséges', 400);
            }
            updateStudent($pdo, $id);
            break;

        case 'DELETE':
            // DELETE /api/students/{id} - Hallgató törlése
            if (!$id) {
                sendError('Törléshez azonosító szükséges', 400);
            }
            deleteStudent($pdo, $id);
            break;

        default:
            sendError("A(z) $method metódus nem engedélyezett", 405);
    }
}


// --- 7.11. Query-paraméterek feldolgozása --------------------

function getStudents(PDO $pdo): void
{
    $page  = max(1, (int)($_GET['page']  ?? 1));
    $limit = min(100, max(1, (int)($_GET['limit'] ?? 10)));
    $sort  = $_GET['sort']  ?? 'name';
    $order = strtoupper($_GET['order'] ?? 'ASC');

    $allowedSorts = ['name', 'email', 'created_at'];
    if (!in_array($sort, $allowedSorts)) $sort = 'name';
    if (!in_array($order, ['ASC', 'DESC'])) $order = 'ASC';

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
                'pages' => (int)ceil($total / $limit)
            ]
        ]);
    } catch (PDOException $e) {
        sendError('Adatbázis hiba', 500);
    }
}


// --- 7.12. Hallgató létrehozása ------------------------------

function createStudent(PDO $pdo): void
{
    $input = getJsonInput();

    if (empty($input['name']) || empty($input['email'])) {
        sendError('Hiányzó kötelező mezők: name, email', 400);
    }

    $name  = trim($input['name']);
    $email = trim($input['email']);

    $errors = [];
    if (mb_strlen($name) < 2 || mb_strlen($name) > 100) {
        $errors['name'] = 'A névnek 2-100 karakter között kell lennie';
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


// --- 7.13. Hallgató lekérése ---------------------------------

function getStudent(PDO $pdo, string $id): void
{
    // ID validálása
    if (!is_numeric($id) || $id < 1) {
        sendError('Érvénytelen azonosító formátum', 400);
    }

    try {
        $sql = "SELECT * FROM students WHERE id = :id";
        $stmt = $pdo->prepare($sql);
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


// --- 7.14. Hallgató módosítása -------------------------------

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
        if (!in_array($field, $allowedFields)) continue;
        $updateFields[] = "$field = :$field";
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


// --- 7.15. Hallgató törlése ----------------------------------

function deleteStudent(PDO $pdo, string $id): void
{
    // ID validálása
    if (!is_numeric($id) || $id < 1) {
        sendError('Érvénytelen azonosító formátum', 400);
    }

    try {
        // Ellenőrizzük, létezik-e a hallgató
        $checkSql = "SELECT * FROM students WHERE id = :id";
        $checkStmt = $pdo->prepare($checkSql);
        $checkStmt->execute([':id' => $id]);
        $student = $checkStmt->fetch();

        if (!$student) {
            sendError('A hallgató nem található', 404);
        }

        // Törlés végrehajtása
        $deleteSql = "DELETE FROM students WHERE id = :id";
        $deleteStmt = $pdo->prepare($deleteSql);
        $deleteStmt->execute([':id' => $id]);

        // Visszaadjuk a törölt hallgató adatait
        sendSuccess(
            $student,
            'Hallgató sikeresen törölve'
        );

    } catch (PDOException $e) {
        sendError('Adatbázis hiba', 500);
    }
}
