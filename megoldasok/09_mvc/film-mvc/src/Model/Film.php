<?php

namespace App\Model;

use App\Core\BaseModel;
use PDO;

/** A films tábla modellje. */
class Film extends BaseModel
{
    public function __construct(PDO $db)
    {
        parent::__construct($db, 'films');
    }

    /** Új film mentése. */
    public function create(string $title,
                           string $director,
                           int    $year,
                           string $genre): bool
    {
        $stmt = $this->db->prepare(
            "INSERT INTO {$this->table} (title, director, year, genre)
             VALUES (:title, :director, :year, :genre)"
        );
        return $stmt->execute(['title' => $title, 'director' => $director, 'year' => $year, 'genre' => $genre]);
    }

    /** Egy film adatainak módosítása. */
    public function update(int    $id,
                           string $title,
                           string $director,
                           int    $year,
                           string $genre): bool
    {
        $stmt = $this->db->prepare(
            "UPDATE {$this->table}
             SET title = :title, director = :director, year = :year, genre = :genre
             WHERE id = :id"
        );
        return $stmt->execute(['title' => $title, 'director' => $director, 'year' => $year, 'genre' => $genre, 'id' => $id]);
    }

    /**
     * Cím vagy rendező neve alapján keres. A kis- és nagybetűt nem különbözteti meg,
     * részleges egyezést is talál.
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
