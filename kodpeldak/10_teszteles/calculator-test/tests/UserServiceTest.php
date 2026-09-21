<?php

// =============================================================
// 10.10. Tesztelés mock PDO-val
// =============================================================

use PHPUnit\Framework\TestCase;

class UserServiceTest extends TestCase
{
    public function testGetUserReturnsUserData(): void
    {
        // Mock PDO objektum létrehozása
        $pdoMock = $this->createMock(PDO::class);
        $stmtMock = $this->createMock(PDOStatement::class);

        // A mock viselkedését definiáljuk
        $stmtMock->method('execute')
                 ->willReturn(true);
        $stmtMock->method('fetch')
                 ->willReturn(['id' => 1, 'name' => 'Test User']);

        $pdoMock->method('prepare')
                ->willReturn($stmtMock);

        // A UserService most a mock PDO-t kapja meg
        $userService = new UserService($pdoMock);

        // A teszt gyors, nincs valódi adatbázis művelet
        $result = $userService->getUser(1);

        $this->assertNotNull($result);
        $this->assertEquals('Test User', $result['name']);
    }
}
