<?php

// =============================================================
// 3.52. Hagyományos osztálybetöltés (main.php)
// =============================================================

require_once 'Student.php';

$student = new Student("Kovács János", 22);
echo $student->getInfo();
// Kimenet: Hallgató: Kovács János, kor: 22
