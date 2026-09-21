<?php

// =============================================================
// 1.9. PHPDoc megjegyzések
// =============================================================

// A példa a dokumentációs megjegyzéseket mutatja be. Csak az osztály
// definícióját tartalmazza, ezért futtatáskor nem ír ki semmit.

/**
 * Felhasználói fiókokat kezelő szolgáltatás.
 *
 * Ez az osztály felelős a felhasználói fiókok létrehozásáért,
 * módosításáért és törléséért.
 */
class UserService
{
    /**
     * Felhasználó keresése e-mail-cím alapján.
     *
     * @param string $email A keresett e-mail-cím
     * @return User|null A megtalált felhasználó vagy null érték
     * @throws InvalidEmailException Hibás e-mail-formátum esetén
     */
    public function findByEmail(string $email): ?User
    {
        // ...
    }

    /**
     * Új felhasználó létrehozása.
     *
     * @param array<string, mixed> $data Felhasználói adatok
     * @return User A létrehozott felhasználó
     */
    public function create(array $data): User
    {
        // ...
    }
}
