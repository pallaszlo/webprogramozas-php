<?php

// =============================================================
// 3.12. Felsorolások (enum típusok)
// =============================================================


// --- 3.47. Egyszerű felsorolás használata --------------------
enum StudentStatus
{
    case Active;
    case Suspended;
    case Graduated;
    case Dropout;
}

$status = StudentStatus::Active;

echo $status->name;  // "Active"

if ($status === StudentStatus::Active) {
    echo "Aktív hallgató";
}

$label = match($status) {
    StudentStatus::Active    => "Aktív",
    StudentStatus::Suspended => "Felfüggesztett",
    StudentStatus::Graduated => "Végzett",
    StudentStatus::Dropout   => "Lemorzsolódott",
};
