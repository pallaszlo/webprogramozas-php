<?php
require_once '00_db.php';

$message = '';

if (isset($_POST['hozzaad'])) {
    try {
        $username = trim($_POST['username'] ?? '');
        $email    = trim($_POST['email']    ?? '');
        $age      = (int)($_POST['age']     ?? 0);
        $city     = trim($_POST['city']     ?? '');

        $stmt = $pdo->prepare("
            INSERT INTO users (username, email, age, city)
            VALUES (:username, :email, :age, :city)
        ");
        $stmt->execute([
            'username' => $username,
            'email'    => $email,
            'age'      => $age,
            'city'     => $city ?: null,
        ]);

        $newId   = (int)$pdo->lastInsertId();
        $message = "Sikeres felvétel! Azonosító: $newId";

    } catch (PDOException $e) {
        if ((int)$e->getCode() === 23000) {
            $message = "Hiba: ez a felhasználónév vagy e-mail már létezik!";
        } else {
            error_log($e->getMessage());
            $message = "Adatbázis-hiba történt.";
        }
    }
}
?><!DOCTYPE html>
<html lang="hu">
<head><meta charset="UTF-8"><title>INSERT</title></head>
<body>

<h1>Felhasználó hozzáadása (INSERT)</h1>

<?php if ($message): ?>
    <p><strong><?= htmlspecialchars($message) ?></strong></p>
<?php endif; ?>

<form method="POST">
    <p><label>Felhasználónév: <input type="text" name="username" required></label></p>
    <p><label>E-mail: <input type="email" name="email" required></label></p>
    <p><label>Kor: <input type="number" name="age" min="1" max="120" value="18"></label></p>
    <p><label>Város: <input type="text" name="city"></label></p>
    <button type="submit" name="hozzaad" value="1">Hozzáadás</button>
</form>

</body>
</html>
