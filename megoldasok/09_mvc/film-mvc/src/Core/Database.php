<?php

namespace App\Core;

use PDO;

/** PDO-kapcsolat létrehozása a megadott adatokkal. */
class Database
{
    private PDO $connection;

    public function __construct(
        private string $host,
        private string $dbname,
        private string $user,
        private string $pass,
    ) {
        $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset=utf8mb4";
        $this->connection = new PDO($dsn, $this->user, $this->pass, [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]);
    }

    /** A létrehozott PDO-kapcsolat. */
    public function getConnection(): PDO
    {
        return $this->connection;
    }
}
