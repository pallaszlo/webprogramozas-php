<?php

namespace App\Core;

use PDO;

/** A modellek közös őse: a táblára vonatkozó általános lekérdezések. */
abstract class BaseModel
{
    protected PDO $db;
    protected string $table;

    public function __construct(PDO $db, string $table)
    {
        $this->db    = $db;
        $this->table = $table;
    }

    /** A tábla összes sora azonosító szerinti sorrendben. */
    public function getAll(): array
    {
        return $this->db
            ->query("SELECT * FROM {$this->table} ORDER BY id ASC")
            ->fetchAll();
    }

    /** Egy sor az azonosítója alapján, vagy null, ha nincs ilyen. */
    public function getById(int $id): ?array
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM {$this->table} WHERE id = :id"
        );
        $stmt->execute(['id' => $id]);
        return $stmt->fetch() ?: null;
    }

    /** Egy sor törlése az azonosítója alapján. */
    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare(
            "DELETE FROM {$this->table} WHERE id = :id"
        );
        return $stmt->execute(['id' => $id]);
    }
}
