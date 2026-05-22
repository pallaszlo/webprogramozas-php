<?php

namespace App\Core;

use PDO;

abstract class BaseModel
{
    protected PDO $db;
    protected string $table;

    public function __construct(PDO $db, string $table)
    {
        $this->db    = $db;
        $this->table = $table;
    }

    public function getAll(): array
    {
        return $this->db
            ->query("SELECT * FROM {$this->table} ORDER BY id ASC")
            ->fetchAll();
    }

    public function getById(int $id): ?array
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM {$this->table} WHERE id = ?"
        );
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare(
            "DELETE FROM {$this->table} WHERE id = ?"
        );
        return $stmt->execute([$id]);
    }
}
