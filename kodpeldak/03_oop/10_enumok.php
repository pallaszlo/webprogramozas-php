<?php

// ============================================================
// Felsorolások (enum): unit enum, backed enum, metódusok
// Kapcsolódó fejezet: 3.8. Felsorolások (enum típusok)
// ============================================================


// --- Unit enum -------------------------------------------------

enum StudentStatus
{
    case Active;
    case Suspended;
    case Graduated;
    case Dropout;
}

$status = StudentStatus::Active;

echo $status->name . PHP_EOL;  // Active

$label = match($status) {
    StudentStatus::Active    => "Aktív",
    StudentStatus::Suspended => "Felfüggesztett",
    StudentStatus::Graduated => "Végzett",
    StudentStatus::Dropout   => "Lemorzsolódott",
};
echo $label . PHP_EOL;  // Aktív


// --- Backed enum (string) --------------------------------------

enum CourseStatus: string
{
    case Draft     = 'draft';
    case Published = 'published';
    case Archived  = 'archived';

    public function label(): string
    {
        return match($this) {
            self::Draft     => "Piszkozat",
            self::Published => "Közzétett",
            self::Archived  => "Archivált",
        };
    }

    public function isVisible(): bool
    {
        return $this === self::Published;
    }
}

$status = CourseStatus::Published;
echo $status->value          . PHP_EOL;  // published
echo $status->label()        . PHP_EOL;  // Közzétett
echo ($status->isVisible() ? "Látható" : "Rejtett") . PHP_EOL;  // Látható

// Értékből visszaalakítás
$fromDb = CourseStatus::from('archived');
echo $fromDb->label()        . PHP_EOL;  // Archivált

$unknown = CourseStatus::tryFrom('invalid');
var_dump($unknown);                       // NULL


// --- Backed enum (int) -----------------------------------------

enum Grade: int
{
    case Excellent    = 10;
    case Good         = 8;
    case Satisfactory = 7;
    case Sufficient   = 6;
    case Pass         = 5;
    case Fail         = 4;

    public function isPassing(): bool
    {
        return $this->value >= 5;
    }
}

$grade = Grade::from(8);
echo $grade->name              . PHP_EOL;  // Good
echo ($grade->isPassing() ? "Megfelelt" : "Nem felelt meg") . PHP_EOL;  // Megfelelt


// --- Összes eset lekérése (cases()) ----------------------------

echo PHP_EOL . "Minden kurzus-státusz:" . PHP_EOL;
foreach (CourseStatus::cases() as $case) {
    printf("  %-12s → %s\n", $case->value, $case->label());
}


// --- Enum használata osztályban --------------------------------

class Course
{
    public function __construct(
        public string       $title,
        public CourseStatus $status = CourseStatus::Draft
    ) {}

    public function publish(): void
    {
        $this->status = CourseStatus::Published;
    }

    public function archive(): void
    {
        $this->status = CourseStatus::Archived;
    }
}

$course = new Course("Webprogramozás");
echo $course->status->label() . PHP_EOL;  // Piszkozat

$course->publish();
echo $course->status->label() . PHP_EOL;  // Közzétett

$course->archive();
echo $course->status->label() . PHP_EOL;  // Archivált
