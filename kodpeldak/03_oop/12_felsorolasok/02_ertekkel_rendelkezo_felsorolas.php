<?php

// =============================================================
// 3.12. Felsorolások (enum típusok)
// =============================================================


// --- 3.48. Felsorolás sztringértékkel ------------------------
enum StudentStatus: string
{
    case Active    = 'active';
    case Suspended = 'suspended';
    case Graduated = 'graduated';
}

echo StudentStatus::Active->value;  // "active"

$status = StudentStatus::from('graduated');  // StudentStatus::Graduated
$status = StudentStatus::tryFrom('invalid'); // null


// --- 3.49. Felsorolás egészszám-értékkel ---------------------
enum Grade: int
{
    case Excellent    = 10;
    case Good         = 8;
    case Satisfactory = 7;
    case Sufficient   = 6;
    case Pass         = 5;
    case Fail         = 4;
}

$grade = Grade::from(8);

echo $grade->value;  // 8
echo $grade->name;   // "Good"
