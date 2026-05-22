<?php
require_once '00_db.php';

$message = '';

if (isset($_POST['torol'])) {
    try {
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = :id");
        $stmt->execute(['id' => (int)($_POST['id'] ?? 0)]);

        $affected = $stmt->rowCount();
        $message  = $affected > 0 ? "Sikeres törlés!" : "Nem létező rekord.";

    } catch (PDOException $e) {
        if ((int)$e->getCode() === 23000) {
            $message = "Nem törölhető: más rekordok hivatkoznak rá.";
        } else {
            error_log($e->getMessage());
            $message = "Adatbázis-hiba történt.";
        }
    }
}

$users = $pdo->query("SELECT id, username, email FROM users ORDER BY id")->fetchAll();
?><!DOCTYPE html>
<html lang="hu">
<head><meta charset="UTF-8"><title>DELETE</title></head>
<body>

<h1>Felhasználó törlése (DELETE)</h1>

<?php if ($message): ?>
    <p><strong><?= htmlspecialchars($message) ?></strong></p>
<?php endif; ?>

<table border="1" cellpadding="4">
    <tr><th>ID</th><th>Felhasználónév</th><th>E-mail</th><th></th></tr>
    <?php foreach ($users as $u): ?>
    <tr>
        <td><?= (int)$u['id'] ?></td>
        <td><?= htmlspecialchars($u['username']) ?></td>
        <td><?= htmlspecialchars($u['email']) ?></td>
        <td>
            <form method="POST" onsubmit="return confirm('Biztosan törlöd?')">
                <input type="hidden" name="id" value="<?= (int)$u['id'] ?>">
                <button type="submit" name="torol" value="1">Törlés</button>
            </form>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

</body>
</html>
