<?php

// =============================================================
// 3.3. Tulajdonságok, metódusok és láthatóság
// =============================================================


// --- 3.14. Az Address és Student osztályok -------------------
class Address
{
    public string $city;
    public string $street;

    public function __construct(string $city, string $street)
    {
        $this->city = $city;
        $this->street = $street;
    }
}

class Student
{
    public string $name;
    public ?Address $address;  // Lehet null

    public function __construct(string $name, ?Address $address = null)
    {
        $this->name = $name;
        $this->address = $address;
    }
}


// --- 3.15. Hagyományos null ellenőrzés -----------------------
$student = new Student("Varga Péter", null);

if ($student->address !== null) {
    echo $student->address->city;
} else {
    echo "Nincs cím";  // Ez fog kiíródni
}


// --- 3.16. Null-safe operátor használata ---------------------
$student = new Student("Varga Péter", null);

$city = $student->address?->city;                 // null (nem dob hibát)
$city = $student->address?->city ?? "Nincs cím";  // "Nincs cím"
echo $city;


// --- 3.17. Null-safe operátor összehasonlítása ---------------
// Hagyományos módszer (hosszú és nehezen olvasható)
$country = null;
if ($student->address !== null) {
    if ($student->address->city !== null) {
        if ($student->address->city->country !== null) {
            $country = $student->address->city->country->name;
        }
    }
}

// Null-safe operátorral (egyszerűbb és tömörebb)
$country = $student->address?->city?->country?->name;
