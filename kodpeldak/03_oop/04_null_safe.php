<?php

// ============================================================
// Null-safe műveletek (?->)
// Kapcsolódó fejezet: 3.2. Null-safe műveletek
// ============================================================


class Address
{
    public function __construct(
        public string $city,
        public string $street
    ) {}
}

class Student
{
    public function __construct(
        public string   $name,
        public ?Address $address = null
    ) {}
}


// --- Hagyományos null-ellenőrzés vs. null-safe operátor -------

$s1 = new Student("Kovács János", new Address("Kolozsvár", "Fő utca 1."));
$s2 = new Student("Varga Péter");  // nincs cím

// Hagyományos módszer
$city1 = $s1->address !== null ? $s1->address->city : null;
$city2 = $s2->address !== null ? $s2->address->city : null;

echo ($city1 ?? "Nincs cím") . PHP_EOL;  // Kolozsvár
echo ($city2 ?? "Nincs cím") . PHP_EOL;  // Nincs cím

// Null-safe operátorral
echo ($s1->address?->city ?? "Nincs cím") . PHP_EOL;  // Kolozsvár
echo ($s2->address?->city ?? "Nincs cím") . PHP_EOL;  // Nincs cím


// --- Láncolás --------------------------------------------------

class City
{
    public function __construct(
        public string  $name,
        public ?string $country = null
    ) {}
}

class Address2
{
    public function __construct(
        public ?City  $city  = null,
        public string $street = ""
    ) {}
}

class Student2
{
    public function __construct(
        public string   $name,
        public ?Address2 $address = null
    ) {}
}

$student = new Student2("Molnár Eszter", new Address2(new City("Budapest", "Magyarország")));

// Mélyen láncolva, bármelyik szint lehet null
$country = $student->address?->city?->country;
echo ($country ?? "Ismeretlen ország") . PHP_EOL;  // Magyarország

$empty = new Student2("Ismeretlen");
echo ($empty->address?->city?->country ?? "Ismeretlen ország") . PHP_EOL;  // Ismeretlen ország
