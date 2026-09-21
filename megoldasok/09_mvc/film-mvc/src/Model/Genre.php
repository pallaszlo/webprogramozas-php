<?php

namespace App\Model;

use App\Core\BaseModel;
use PDO;

/**
 * 4. feladat: a genres tábla modellje.
 * A getAll(), getById() és delete() metódusokat a BaseModel biztosítja.
 */
class Genre extends BaseModel
{
    public function __construct(PDO $db)
    {
        parent::__construct($db, 'genres');
    }

    /** Új műfaj mentése. */
    public function create(string $name): bool
    {
        $stmt = $this->db->prepare(
            "INSERT INTO {$this->table} (name) VALUES (:name)"
        );
        return $stmt->execute(['name' => $name]);
    }

    /** Igaz, ha ilyen nevű műfaj már létezik. */
    public function existsByName(string $name): bool
    {
        $stmt = $this->db->prepare(
            "SELECT COUNT(*) FROM {$this->table} WHERE name = :name"
        );
        $stmt->execute(['name' => $name]);
        return (int)$stmt->fetchColumn() > 0;
    }
}
