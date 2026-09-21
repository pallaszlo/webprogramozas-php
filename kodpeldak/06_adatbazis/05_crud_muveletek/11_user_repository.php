<?php

// =============================================================
// 6.16. UserRepository osztály
// =============================================================

// Előkészítés a futtatáshoz (nem része a könyvbeli kódpéldának)
require __DIR__ . '/../db.php';

class UserRepository {
    public function __construct(
        private PDO $pdo
    ) {}

    public function create(string $username, string $email, int $age): int
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO users (username, email, age, created_at)
            VALUES (:username, :email, :age, NOW())
        ");

        $stmt->execute([
            'username' => $username,
            'email'    => $email,
            'age'      => $age,
        ]);

        return (int) $this->pdo->lastInsertId();
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute(['id' => $id]);

        $user = $stmt->fetch();
        return $user ?: null;
    }

    // findAll(), update(), delete() ugyanezt a mintát követik
}


// Kiegészítés (nem szerepel a könyvben): az osztály használata
$repo = new UserRepository($pdo);

$user = $repo->findById(1);
echo "findById(1): " . htmlspecialchars($user['username']) . "<br>";
echo "findById(999): " . var_export($repo->findById(999), true);
