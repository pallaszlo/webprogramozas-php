<?php
require_once '01_db.php';

$perPage = 3;
$page    = max(1, (int)($_GET['page'] ?? 1));
$offset  = ($page - 1) * $perPage;

$total = (int)$pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();
$pages = (int)ceil($total / $perPage);

$stmt = $pdo->prepare("
    SELECT p.id, p.name, p.price, p.stock, c.name AS category_name
    FROM products p
    LEFT JOIN categories c ON p.category_id = c.id
    ORDER BY p.name ASC
    LIMIT :limit OFFSET :offset
");
$stmt->bindValue('limit',  $perPage, PDO::PARAM_INT);
$stmt->bindValue('offset', $offset,  PDO::PARAM_INT);
$stmt->execute();
$products = $stmt->fetchAll();
?><!DOCTYPE html>
<html lang="hu">
<head><meta charset="UTF-8"><title>Termékek kategóriával</title></head>
<body>

<h1>Termékek kategóriával – lapozással</h1>
<p>Összesen: <?= $total ?> termék &nbsp;|&nbsp; Oldal: <?= $page ?>/<?= max(1, $pages) ?></p>

<table border="1" cellpadding="6">
    <tr><th>ID</th><th>Név</th><th>Ár (RON)</th><th>Készlet</th><th>Kategória</th></tr>
    <?php foreach ($products as $p): ?>
    <tr>
        <td><?= (int)$p['id'] ?></td>
        <td><?= htmlspecialchars($p['name']) ?></td>
        <td><?= number_format((float)$p['price'], 2) ?></td>
        <td><?= (int)$p['stock'] ?></td>
        <td><?= htmlspecialchars($p['category_name'] ?? '–') ?></td>
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
