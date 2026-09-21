<?php

// =============================================================
// 7.7. Adatbázis-kapcsolat (config.php)
// =============================================================

// Adatbázis kapcsolat konfigurációja
define('DB_HOST', 'localhost');
define('DB_NAME', 'student_api');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

// PDO kapcsolat létrehozása
function getDbConnection(): PDO
{
    static $pdo = null;

    if ($pdo === null) {
        $dsn = sprintf(
            "mysql:host=%s;dbname=%s;charset=%s",
            DB_HOST,
            DB_NAME,
            DB_CHARSET
        );

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        try {
            $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch (PDOException $e) {
            // Éles környezetben ne adjunk ki részletes hibaüzenetet!
            http_response_code(500);
            echo json_encode([
                'status' => 'error',
                'message' => 'Adatbázis kapcsolódási hiba'
            ]);
            exit;
        }
    }

    return $pdo;
}
