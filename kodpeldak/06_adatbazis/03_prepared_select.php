<?php
require_once '00_db.php';
?><!DOCTYPE html>
<html lang="hu">
<head><meta charset="UTF-8"><title>SELECT – Prepared statement</title></head>
<body>

<h1>SELECT lekérdezések</h1>

<h2>1. Egyszerű lekérdezés – query()</h2>
<p>Csak statikus SQL esetén (nincs felhasználói bemenet).</p>
<?php
$stmt = $pdo->query("SELECT id, username, email FROM users ORDER BY username ASC");
while ($row = $stmt->fetch()) {
    echo htmlspecialchars($row['username']) . " – " . htmlspecialchars($row['email']) . "<br>";
}
?>

<h2>2. Named placeholder</h2>
<?php
$stmt = $pdo->prepare("
    SELECT id, username, city
    FROM users
    WHERE age > :min_age AND city = :city
");
$stmt->execute(['min_age' => 20, 'city' => 'Budapest']);
$users = $stmt->fetchAll();

foreach ($users as $row) {
    echo htmlspecialchars($row['username']) . " – " . htmlspecialchars($row['city']) . "<br>";
}
echo "Találatok: " . count($users);
?>

<h2>3. Positional placeholder</h2>
<?php
$stmt = $pdo->prepare("
    SELECT id, username, age FROM users
    WHERE age > ? AND age < ?
    ORDER BY age ASC
");
$stmt->execute([20, 40]);

while ($row = $stmt->fetch()) {
    echo htmlspecialchars($row['username']) . " (kor: " . (int)$row['age'] . ")<br>";
}
?>

</body>
</html>
