<?php

// =============================================================
// 9.3. Student modell osztály
// =============================================================

namespace App\Model;

class Student
{
    private string $table = 'students';

    public function __construct(private \PDO $db) {}

    public function getAll(): array
    {
        return $this->db->query(
            "SELECT * FROM {$this->table} ORDER BY name ASC"
        )->fetchAll();
    }

    public function getById(int $id): ?array
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM {$this->table} WHERE id = :id"
        );
        $stmt->execute(['id' => $id]);
        return $stmt->fetch() ?: null;
    }

    public function create(string $name, string $email): bool
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        $stmt = $this->db->prepare(
            "INSERT INTO {$this->table} (name, email) VALUES (:name, :email)"
        );
        return $stmt->execute(['name' => $name, 'email' => $email]);
    }

    // update() és delete() metódusok hasonlóan...
}
