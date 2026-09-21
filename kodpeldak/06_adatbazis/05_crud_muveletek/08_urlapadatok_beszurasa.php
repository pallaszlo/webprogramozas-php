<?php

// =============================================================
// 6.13. Űrlapadatok beszúrása
// =============================================================

// Előkészítés a futtatáshoz (nem része a könyvbeli kódpéldának)
require __DIR__ . '/../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $username = trim($_POST['username'] ?? '');
        $email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
        $age = filter_var($_POST['age'] ?? 0, FILTER_VALIDATE_INT);

        if (empty($username)) {
            throw new Exception("A felhasználónév kötelező!");
        }

        if ($email === false) {
            throw new Exception("Érvénytelen e-mail cím!");
        }

        if ($age === false || $age < 18 || $age > 120) {
            throw new Exception("Az életkornak 18 és 120 között kell lennie!");
        }

        $stmt = $pdo->prepare("
            INSERT INTO users (username, email, age, created_at)
            VALUES (:username, :email, :age, NOW())
        ");

        $stmt->execute([
            'username' => $username,
            'email'    => $email,
            'age'      => $age
        ]);

        $userId = (int) $pdo->lastInsertId();
        echo "Sikeres regisztráció! Azonosító: " . $userId;

    } catch (PDOException $e) {
        if ((int)$e->getCode() === 23000) {
            echo "Ez az e-mail cím vagy felhasználónév már regisztrálva van!";
        } else {
            error_log("Beszúrási hiba: " . $e->getMessage());
            echo "Hiba történt a regisztráció során.";
        }
    } catch (Exception $e) {
        echo "Hiba: " . htmlspecialchars($e->getMessage());
    }
}
?>

<!-- Kiegészítés (nem szerepel a könyvben): a regisztrációs űrlap -->
<form method="POST">
    <input type="text" name="username" placeholder="Felhasználónév">
    <input type="text" name="email" placeholder="E-mail-cím">
    <input type="number" name="age" placeholder="Életkor">
    <input type="submit" value="Regisztráció">
</form>
