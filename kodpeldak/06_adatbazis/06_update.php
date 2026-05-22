<?php
require_once '00_db.php';

$message = '';

if (isset($_POST['frissit'])) {
    try {
        $stmt = $pdo->prepare("
            UPDATE users
            SET email = :email, city = :city
            WHERE id = :id
        ");
        $stmt->execute([
            'email' => trim($_POST['email'] ?? ''),
            'city'  => trim($_POST['city']  ?? '') ?: null,
            'id'    => (int)($_POST['id']   ?? 0),
        ]);

        $affected = $stmt->rowCount();
        $message  = $affected > 0
            ? "Sikeres módosítás! ($affected sor érintett)"
            : "Nem volt módosítható rekord.";

    } catch (PDOException $e) {
        error_log($e->getMessage());
        $message = "Adatbázis-hiba történt.";
    }
}

$users = $pdo->query("SELECT id, username, email, city FROM users ORDER BY id")->fetchAll();
?><!DOCTYPE html>
<html lang="hu">
<head><meta charset="UTF-8"><title>UPDATE</title></head>
<body>

<h1>Felhasználó módosítása (UPDATE)</h1>

<?php if ($message): ?>
    <p><strong><?= htmlspecialchars($message) ?></strong></p>
<?php endif; ?>

<form method="POST">
    <p><label>Felhasználó:
        <select name="id">
            <?php foreach ($users as $u): ?>
                <option value="<?= (int)$u['id'] ?>"><?= htmlspecialchars($u['username']) ?></option>
            <?php endforeach; ?>
        </select>
    </label></p>
    <p><label>Új e-mail: <input type="email" name="email" required></label></p>
    <p><label>Új város: <input type="text" name="city"></label></p>
    <button type="submit" name="frissit" value="1">Módosítás</button>
</form>

<h2>Aktuális adatok</h2>
<table border="1" cellpadding="4">
    <tr><th>ID</th><th>Felhasználónév</th><th>E-mail</th><th>Város</th></tr>
    <?php foreach ($users as $u): ?>
    <tr>
        <td><?= (int)$u['id'] ?></td>
        <td><?= htmlspecialchars($u['username']) ?></td>
        <td><?= htmlspecialchars($u['email']) ?></td>
        <td><?= htmlspecialchars($u['city'] ?? '–') ?></td>
    </tr>
    <?php endforeach; ?>
</table>

</body>
</html>
