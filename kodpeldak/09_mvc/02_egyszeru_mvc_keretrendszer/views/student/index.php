<?php /* 9.6. Hallgatók listája (index.php) */ ?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Hallgatók listája</title>
</head>
<body>
    <h1>Hallgatók</h1>
    <a href="index.php?action=create">Új hallgató</a>

    <table>
        <thead>
            <tr><th>Név</th><th>Email</th><th>Műveletek</th></tr>
        </thead>
        <tbody>
            <?php foreach ($students as $row): ?>
            <tr>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td>
                    <a href="index.php?action=show&id=<?= $row['id'] ?>">
                        Megtekintés
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
