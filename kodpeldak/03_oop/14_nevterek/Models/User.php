<?php

// =============================================================
// 3.54. Névtér deklarálása (Models/User.php)
// =============================================================

namespace MyProject\Models;

class User
{
    private int $id;
    private string $name;

    public function __construct(int $id, string $name)
    {
        $this->id   = $id;
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
