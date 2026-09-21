<?php

// =============================================================
// 9.14. Student modell osztály
// =============================================================

namespace App\Model;

use App\Core\BaseModel;

class Student extends BaseModel
{
    public function __construct(\PDO $db)
    {
        parent::__construct($db, 'students');
    }

    // Csak a specifikus metódusokat kell implementálni
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

    // A getAll(), getById(), delete()
    // már a BaseModel-ben van!
}
