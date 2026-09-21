<?php

// =============================================================
// 10.4–10.9. Assertion metódusok
// =============================================================
// A könyv a tesztmetódusokat önmagukban mutatja, itt egy osztályba kerültek.

use PHPUnit\Framework\TestCase;

// Kiegészítés (nem szerepel a könyvben): a 10.6. példa findUser() függvénye
function findUser(int $id): ?array
{
    $users = [1 => ['id' => 1, 'name' => 'Kiss Anna']];
    return $users[$id] ?? null;
}

class AssertionTest extends TestCase
{
    // --- 10.4. Egyenlőség és azonosság ellenőrzése ---------------
    public function testEquality(): void
    {
        // Egyenlőség ellenőrzése (tartalom)
        $this->assertEquals(42, 42);
        $this->assertEquals('hello', 'hello');

        // Azonosság ellenőrzése (típus és érték)
        $this->assertSame(42, 42);
        $this->assertNotSame(42, '42');  // különböző típusok
    }

    // --- 10.5. Logikai értékek ellenőrzése -----------------------
    public function testBooleans(): void
    {
        $userIsAdmin = true;
        $this->assertTrue($userIsAdmin);

        $accountIsLocked = false;
        $this->assertFalse($accountIsLocked);
    }

    // --- 10.6. Null értékek ellenőrzése --------------------------
    public function testNull(): void
    {
        $result = findUser(999);
        $this->assertNull($result);  // nem talált felhasználót

        $result = findUser(1);
        $this->assertNotNull($result);  // talált felhasználót
    }

    // --- 10.7. Tömbök ellenőrzése --------------------------------
    public function testArrays(): void
    {
        $roles = ['admin', 'editor', 'viewer'];

        // Tömb tartalmazását ellenőrzi
        $this->assertContains('editor', $roles);

        // Tömb elemszámát ellenőrzi
        $this->assertCount(3, $roles);

        // Üres tömb ellenőrzése
        $emptyList = [];
        $this->assertEmpty($emptyList);
        $this->assertNotEmpty($roles);
    }

    // --- 10.8. Sztringek ellenőrzése -----------------------------
    public function testStrings(): void
    {
        $message = 'Error: Invalid email address';

        // String tartalmaz részstringet
        $this->assertStringContainsString('email', $message);

        // String mintaillesztés
        $this->assertMatchesRegularExpression('/^Error:/', $message);
    }

    // --- 10.9. Típusellenőrzések ---------------------------------
    public function testTypes(): void
    {
        $age = 25;
        $this->assertIsInt($age);

        $name = 'John';
        $this->assertIsString($name);

        $scores = [85, 90, 78];
        $this->assertIsArray($scores);

        $isActive = true;
        $this->assertIsBool($isActive);

        $price = 99.99;
        $this->assertIsFloat($price);
    }
}
