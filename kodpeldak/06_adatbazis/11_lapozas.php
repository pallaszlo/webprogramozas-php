<?php
require_once '00_db.php';

$perPage = 2;
$page    = max(1, (int)($_GET['page'] ?? 1));
$offset  = ($page - 1) * $perPage;

$total = (int)$pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
$pages = (int)ceil($total / $perPage);

$stmt = $pdo->prepare("
    SELECT id, username, email, city
    FROM users
    ORDER BY id ASC
    LIMIT :limit OFFSET :offset
");
$stmt->bindValue('limit',  $perPage, PDO::PARAM_INT);
$stmt->bindValue('offset', $offset,  PDO::PARAM_INT);
$stmt->execute();
$users = $stmt->fetchAll();
?><!DOCTYPE html>
<html lang="hu">
<head><meta charset="UTF-8"><title>Lapozás</title></head>
<body>

<h1>Felhasználók – lapozással</h1>
<p>Összesen: <?= $total ?> rekord &nbsp;|&nbsp; Oldal: <?= $page ?>/<?= max(1, $pages) ?></p>

<table border="1" cellpadding="6">
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

<p>
    <?php if ($page > 1): ?>
        <a href="?page=<?= $page - 1 ?>">← Előző</a> &nbsp;
    <?php endif; ?>
    <?php for ($i = 1; $i <= $pages; $i++): ?>
        <?php if ($i === $page): ?>
            <strong>[<?= $i ?>]</strong>
        <?php else: ?>
            <a href="?page=<?= $i ?>"><?= $i ?></a>
        <?php endif; ?>
    <?php endfor; ?>
    <?php if ($page < $pages): ?>
        &nbsp; <a href="?page=<?= $page + 1 ?>">Következő →</a>
    <?php endif; ?>
</p>

</body>
</html>
