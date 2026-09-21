<?php

// =============================================================
// 9.2. Adatbázis-kapcsolat (Database.php)
// =============================================================

namespace App\Core;

use PDO;

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'student_mvc');

class Database
{
    private PDO $connection;

    public function __construct()
    {
        $dsn = sprintf('mysql:host=%s;dbname=%s;charset=utf8mb4', DB_HOST, DB_NAME);
        $this->connection = new PDO($dsn, DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]);
    }

    public function getConnection(): PDO
    {
        return $this->connection;
    }
}
