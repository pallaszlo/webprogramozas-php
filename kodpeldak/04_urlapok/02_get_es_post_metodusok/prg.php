<?php

// =============================================================
// 4.13. PRG-minta implementálása (prg.php)
// =============================================================

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validáció
    $name = trim($_POST['name'] ?? '');

    if (empty($name)) {
        // Hiba esetén az adatokat és a hibaüzenetet session-ben tároljuk
        $_SESSION['error'] = "A név megadása kötelező!";
        $_SESSION['form_data'] = $_POST;
        header("Location: prg.php");
        exit;
    }

    // Sikeres feldolgozás (pl. adatbázisba mentés)
    // ...

    // Sikerüzenet session-ben
    $_SESSION['success'] = "Sikeres mentés!";

    // Átirányítás GET kérésre (PRG)
    header("Location: prg.php");
    exit; // A Location fejléc után állítsuk le a szkriptet
}

// Üzenetek és korábbi adatok kiolvasása, majd törlése
$error = $_SESSION['error'] ?? null;
$success = $_SESSION['success'] ?? null;
$formData = $_SESSION['form_data'] ?? [];

unset($_SESSION['error'], $_SESSION['success'], $_SESSION['form_data']);
?>

<!DOCTYPE html>
<html>
<head><title>PRG példa</title></head>
<body>
    <?php if ($success): ?>
        <p style="color: green;"><?= htmlspecialchars($success) ?></p>
    <?php endif; ?>

    <?php if ($error): ?>
        <p style="color: red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="POST">
        <label>Név:</label>
        <input type="text" name="name"
               value="<?= htmlspecialchars($formData['name'] ?? '') ?>">
        <input type="submit" value="Küldés">
    </form>
</body>
</html>
