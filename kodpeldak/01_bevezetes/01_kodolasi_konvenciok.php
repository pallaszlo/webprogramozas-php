<?php

// =============================================================
// 1.5. Kódolási konvenciók
// =============================================================

// Az 1.5. és az 1.6. példa csak osztálydefiníciókat tartalmaz, ezért
// kimenetet csak az 1.7. rész ad.


// --- 1.5. PSR-1 példák ---------------------------------------
// Osztálynév: PascalCase
class UserRepository
{
    // Konstans: UPPER_CASE
    public const MAX_LOGIN_ATTEMPTS = 5;

    // Metódusnév: camelCase
    public function findById(int $id): ?User
    {
        // ...
    }

    public function getUserByEmail(string $email): ?User
    {
        // ...
    }
}


// --- 1.6. Kapcsos zárójelek elhelyezése ----------------------
// Osztályoknál és metódusoknál: új sorban
class UserService
{
    public function createUser(string $name, string $email): User
    {
        // Vezérlési szerkezeteknél: azonos sorban
        if ($this->userExists($email)) {
            throw new UserExistsException();
        }

        foreach ($this->validators as $validator) {
            $validator->validate($name);
        }

        return new User($name, $email);
    }
}


// --- 1.7. Szóközök használata --------------------------------
// Előkészítés a futtatáshoz (nem része a könyvbeli kódpéldának)
$condition = true;
$items = ['a' => 1];
$price = 250;
$quantity = 3;
$firstName = 'Anna';
$lastName = 'Kovács';

function calculateTotal(int $price, int $quantity): int
{
    return $price * $quantity;
}

// Vezérlési szerkezetek után szóköz
if ($condition) {
    // ...
}

foreach ($items as $key => $value) {
    // ...
}

// Függvényhívásnál nincs szóköz
$result = calculateTotal($price, $quantity);

// Operátorok körül szóköz
$total = $price * $quantity;
$name = $firstName . ' ' . $lastName;


// Kiegészítés (nem szerepel a könyvben): a kiszámolt értékek
echo $result . "\n";   // 750
echo $total . "\n";    // 750
echo $name . "\n";     // Anna Kovács
