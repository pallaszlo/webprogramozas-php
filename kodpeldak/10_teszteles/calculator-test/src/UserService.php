<?php

// Kiegészítés (nem szerepel a könyvben): a 10.10. kódpélda által tesztelt osztály.
// A PDO-kapcsolatot a konstruktor kapja (Dependency Injection), ezért a tesztben
// helyettesíthető mock objektummal.

class UserService
{
    public function __construct(private PDO $pdo) {}

    public function getUser(int $id): ?array
    {
        $stmt = $this->pdo->prepare('SELECT id, name FROM users WHERE id = :id');
        $stmt->execute(['id' => $id]);

        return $stmt->fetch() ?: null;
    }
}
