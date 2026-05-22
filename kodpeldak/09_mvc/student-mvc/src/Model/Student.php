<?php

namespace App\Model;

use App\Core\BaseModel;
use PDO;

class Student extends BaseModel
{
    public function __construct(PDO $db)
    {
        parent::__construct($db, 'students');
    }

    public function create(string $name, string $email): bool
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        $stmt = $this->db->prepare(
            "INSERT INTO {$this->table} (name, email) VALUES (?, ?)"
        );
        return $stmt->execute([$name, $email]);
    }

    public function update(int $id, string $name, string $email): bool
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        $stmt = $this->db->prepare(
            "UPDATE {$this->table} SET name = ?, email = ? WHERE id = ?"
        );
        return $stmt->execute([$name, $email, $id]);
    }
}
