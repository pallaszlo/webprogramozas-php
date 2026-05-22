<?php

namespace App\Model;

use App\Core\BaseModel;
use PDO;

class Film extends BaseModel
{
    public function __construct(PDO $db)
    {
        parent::__construct($db, 'films');
    }

    public function create(string $title,
                           string $director,
                           int    $year,
                           string $genre): bool
    {
        $stmt = $this->db->prepare(
            "INSERT INTO {$this->table} (title, director, year, genre)
             VALUES (?, ?, ?, ?)"
        );
        return $stmt->execute([$title, $director, $year, $genre]);
    }

    public function update(int    $id,
                           string $title,
                           string $director,
                           int    $year,
                           string $genre): bool
    {
        $stmt = $this->db->prepare(
            "UPDATE {$this->table}
             SET title = ?, director = ?, year = ?, genre = ?
             WHERE id = ?"
        );
        return $stmt->execute([$title, $director, $year, $genre, $id]);
    }

    /**
     * Cím vagy rendező neve alapján keres (case-insensitive, részleges egyezés).
     */
    public function search(string $query): array
    {
        $like = '%' . $query . '%';
        $stmt = $this->db->prepare(
            "SELECT * FROM {$this->table}
             WHERE title LIKE ? OR director LIKE ?
             ORDER BY id ASC"
        );
        $stmt->execute([$like, $like]);
        return $stmt->fetchAll();
    }
}
