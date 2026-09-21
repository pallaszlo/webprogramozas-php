<?php

// =============================================================
// 3.57. Névtérelemek elérése
// =============================================================

namespace MyProject;

// Előkészítés a futtatáshoz (nem része a könyvbeli kódpéldának)
require_once 'Models/User.php';

// Nem minősített név: az aktuális névtérben található elem
class MyClass {}
$a = new MyClass();

// Minősített név: részleges útvonal
$b = new Models\User(1, 'Kovács János');

// Teljesen minősített név: abszolút útvonal
$c = new \MyProject\Models\User(1, 'Kovács János');
