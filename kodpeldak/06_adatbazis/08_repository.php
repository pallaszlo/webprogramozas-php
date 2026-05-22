<?php
require_once '00_db.php';

class UserRepository
{
    public function __construct(
        private PDO $pdo
    ) {}

    public function create(string $username, string $email, int $age): int
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO users (username, email, age)
            VALUES (:username, :email, :age)
        ");
        $stmt->execute([
            'username' => $username,
            'email'    => $email,
            'age'      => $age,
        ]);
        return (int)$this->pdo->lastInsertId();
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $user = $stmt->fetch();
        return $user ?: null;
    }

    public function findAll(): array
    {
        return $this->pdo->query("SELECT * FROM users ORDER BY username ASC")->fetchAll();
    }

    public function update(int $id, string $email, ?string $city): bool
    {
        $stmt = $this->pdo->prepare("
            UPDATE users SET email = :email, city = :city WHERE id = :id
        ");
        $stmt->execute(['email' => $email, 'city' => $city, 'id' => $id]);
        return $stmt->rowCount() > 0;
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM users WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->rowCount() > 0;
    }
}

// --- Használat ---

$repo  = new UserRepository($pdo);
$users = $repo->findAll();
?><!DOCTYPE html>
<html lang="hu">
<head><meta charset="UTF-8"><title>Repository minta</title></head>
<body>

<h1>UserRepository – példa</h1>

<h2>findAll()</h2>
<ul>
    <?php foreach ($users as $u): ?>
        <li><?= htmlspecialchars($u['username']) ?> – <?= htmlspecialchars($u['email']) ?></li>
    <?php endforeach; ?>
</ul>

<?php
$user = $repo->findById(1);
if ($user):
?>
<h2>findById(1)</h2>
<p><?= htmlspecialchars($user['username']) ?>, kor: <?= (int)$user['age'] ?>, város: <?= htmlspecialchars($user['city'] ?? '–') ?></p>
<?php endif; ?>

</body>
</html>
