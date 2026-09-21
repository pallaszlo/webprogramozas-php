<?php

// =============================================================
// 9.1. Helytelen példa: minden logika egy fájlban
// =============================================================
// A helytelen megközelítés bemutatása. A futtatáshoz egy "students" nevű
// adatbázis kellene. A fejezet többi példája a student_mvc adatbázist használja.

// adatbázis kapcsolat
$pdo = new PDO("mysql:host=localhost;dbname=students", "root", "");

// lekérdezés
$stmt = $pdo->query("SELECT * FROM students");

// HTML megjelenítés
echo "<html><body>";
echo "<table>";
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "<tr><td>{$row['name']}</td></tr>";
}
echo "</table>";
echo "</body></html>";
