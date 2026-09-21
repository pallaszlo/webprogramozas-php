<?php

// =============================================================
// 3.12. Felsorolások (enum típusok)
// =============================================================


// --- 3.50. Felsorolás metódusokkal és konstansokkal ----------
enum StudentStatus: string
{
    case Active    = 'active';
    case Suspended = 'suspended';
    case Graduated = 'graduated';

    public const DEFAULT = self::Active;

    public function label(): string
    {
        return match($this) {
            self::Active    => 'Aktív',
            self::Suspended => 'Felfüggesztett',
            self::Graduated => 'Végzett',
        };
    }

    public function canEnroll(): bool
    {
        return $this === self::Active;
    }

    public static function activeStatuses(): array
    {
        return [self::Active];
    }
}

echo StudentStatus::Active->label();                      // "Aktív"
echo StudentStatus::Active->canEnroll() ? 'Igen' : 'Nem';

$default = StudentStatus::DEFAULT;
$active  = StudentStatus::activeStatuses();


// --- 3.51. Felsorolás értékeinek lekérése --------------------
$allStatuses = StudentStatus::cases();

foreach ($allStatuses as $status) {
    echo $status->name . ': ' . $status->value . "\n";
}


// =============================================================
// Kiegészítés: további példák, ezek nem szerepelnek a könyvben
// =============================================================
echo "\n--- Kiegészítés ---\n";

// Felsorolás egy osztály tulajdonságának típusaként
enum CourseStatus: string
{
    case Draft     = 'draft';
    case Published = 'published';
    case Archived  = 'archived';

    public function label(): string
    {
        return match ($this) {
            self::Draft     => "Piszkozat",
            self::Published => "Közzétett",
            self::Archived  => "Archivált",
        };
    }
}

class Course
{
    public function __construct(
        public string $title,
        public CourseStatus $status = CourseStatus::Draft
    ) {}

    public function publish(): void
    {
        $this->status = CourseStatus::Published;
    }
}

$course = new Course("Webprogramozás");
echo $course->status->label() . "\n";  // Piszkozat

$course->publish();
echo $course->status->label() . "\n";  // Közzétett

// Adatbázisból érkező értékből visszaalakítás
echo CourseStatus::from('archived')->label() . "\n";  // Archivált
