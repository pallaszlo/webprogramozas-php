<?php
require_once '00_db.php';
?><!DOCTYPE html>
<html lang="hu">
<head><meta charset="UTF-8"><title>SQL Injection</title></head>
<body>

<h1>SQL Injection példa</h1>

<h2>1. Sebezhető változat</h2>
<?php
// VESZÉLYES: soha ne csináljuk ezt!
$username = $_GET['username'] ?? 'kiss_janos';
$sql = "SELECT * FROM users WHERE username = '$username'";
echo "<p>SQL: <code>" . htmlspecialchars($sql) . "</code></p>";

try {
    $stmt = $pdo->query($sql);
    $users = $stmt->fetchAll();
    echo "<p>Találatok: " . count($users) . "</p>";
} catch (PDOException $e) {
    echo "<p style='color:red'>Hiba: " . htmlspecialchars($e->getMessage()) . "</p>";
}
?>
<p>Próbáld ki ezt az URL-ben: <code>?username=%27+OR+%271%27%3D%271</code></p>
<p>A bemenet: <code>' OR '1'='1</code> — az összes rekordot visszaadja!</p>

<h2>2. Biztonságos változat – prepared statement</h2>
<?php
$username = $_GET['username'] ?? 'kiss_janos';

$stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
$stmt->execute(['username' => $username]);
$users = $stmt->fetchAll();

echo "<p>Találatok: " . count($users) . "</p>";
echo "<p>A bemenet nem értelmeződik SQL kódként, biztonságosan kezelt.</p>";
?>

</body>
</html>
