<?php
define('DB_HOST',    'localhost');
define('DB_NAME',    'stocks_api');
define('DB_USER',    'root');
define('DB_PASS',    '');
define('DB_CHARSET', 'utf8mb4');

// Token titkos kulcs – éles környezetben .env fájlból töltsd be (lásd 8. fejezet)!
$_ENV['SECRET_KEY'] = 'titkos-kulcs-csere-le-eles-kornyezetben';

function getDbConnection(): PDO
{
    static $pdo = null;

    if ($pdo === null) {
        $dsn = sprintf(
            "mysql:host=%s;dbname=%s;charset=%s",
            DB_HOST, DB_NAME, DB_CHARSET
        );
        try {
            $pdo = new PDO($dsn, DB_USER, DB_PASS, [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ]);
        } catch (PDOException $e) {
            http_response_code(500);
            header('Content-Type: application/json; charset=UTF-8');
            echo json_encode(['status' => 'error', 'message' => 'Adatbázis kapcsolódási hiba']);
            exit;
        }
    }

    return $pdo;
}
