<?php

// ============================================================
// Automatikus osztálybetöltés
// Kapcsolódó fejezet: 3.9. Automatikus osztálybetöltés
// ============================================================

require 'autoloader.php';

// Student és Course osztályok automatikusan töltődnek be,
// nincs szükség kézi require hívásokra

$student = new Student("S001", "Molnár Eszter");
$student->enroll("Webprogramozás");
$student->enroll("Adatbázisok");
echo $student->getInfo() . PHP_EOL;

$course = new Course("WEB101", "Webprogramozás", 5);
echo $course->getInfo() . PHP_EOL;
