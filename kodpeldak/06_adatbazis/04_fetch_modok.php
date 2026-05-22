<?php
require_once '00_db.php';
?><!DOCTYPE html>
<html lang="hu">
<head><meta charset="UTF-8"><title>Fetch módok</title></head>
<body>

<h1>PDO lekérési módok</h1>

<h2>1. fetch() – egyetlen sor</h2>
<?php
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
$stmt->execute(['id' => 1]);
$user = $stmt->fetch(); // FETCH_ASSOC az alapértelmezett (ajánlott konfig)

if ($user) {
    echo "Felhasználó: " . htmlspecialchars($user['username']);
    echo " (kor: " . (int)$user['age'] . ", város: " . htmlspecialchars($user['city'] ?? '–') . ")";
} else {
    echo "Nem található.";
}
?>

<h2>2. fetchAll() – összes sor tömbként</h2>
<?php
$stmt = $pdo->query("SELECT id, username, city FROM users ORDER BY username ASC");
$users = $stmt->fetchAll();

echo "<table border='1' cellpadding='4'>";
echo "<tr><th>ID</th><th>Felhasználónév</th><th>Város</th></tr>";
foreach ($users as $row) {
    echo "<tr>";
    echo "<td>" . (int)$row['id'] . "</td>";
    echo "<td>" . htmlspecialchars($row['username']) . "</td>";
    echo "<td>" . htmlspecialchars($row['city'] ?? '–') . "</td>";
    echo "</tr>";
}
echo "</table>";
?>

<h2>3. PDO::FETCH_OBJ – stdClass objektum</h2>
<?php
$stmt = $pdo->query("SELECT id, username, city FROM users ORDER BY username ASC");
$users = $stmt->fetchAll(PDO::FETCH_OBJ);

echo "<table border='1' cellpadding='4'>";
echo "<tr><th>ID</th><th>Felhasználónév</th><th>Város</th></tr>";
foreach ($users as $user) {
    echo "<tr>";
    echo "<td>" . (int)$user->id . "</td>";
    echo "<td>" . htmlspecialchars($user->username) . "</td>";
    echo "<td>" . htmlspecialchars($user->city ?? '–') . "</td>";
    echo "</tr>";
}
echo "</table>";
?>

<h2>4. fetchColumn() – egyetlen érték</h2>
<?php
$count = (int)$pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
echo "Felhasználók száma: " . $count;
?>

<h2>Megjegyzés</h2>
<p>A <code>fetchAll()</code> az összes sort egyszerre a memóriába tölti.
Nagy adatmennyiségnél a <code>fetch()</code> + <code>while</code> kombináció ajánlott.</p>

</body>
</html>
