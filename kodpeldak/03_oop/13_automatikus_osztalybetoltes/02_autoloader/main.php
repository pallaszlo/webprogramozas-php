<?php

// =============================================================
// 3.53. Autoloader regisztrálása (main.php)
// =============================================================

require 'autoloader.php';

$student = new Student("Kovács János", 22);
echo $student->getInfo();

$course = new Course("Webprogramozás", 3);
echo $course->getInfo();
