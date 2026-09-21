<?php

namespace App\Core;

/** Egyszerű függőséginjektáló konténer: a szolgáltatásokat az első kéréskor hozza létre. */
class Container
{
    private array $services  = [];
    private array $instances = [];

    /** Szolgáltatás regisztrálása egy létrehozó függvénnyel. */
    public function set(string $id, callable $resolver): void
    {
        $this->services[$id] = $resolver;
        unset($this->instances[$id]);
    }

    /** A szolgáltatás példánya. Első híváskor létrehozza, utána ugyanazt adja vissza. */
    public function get(string $id): mixed
    {
        if (isset($this->instances[$id])) {
            return $this->instances[$id];
        }

        if (!isset($this->services[$id])) {
            throw new \RuntimeException("Service '{$id}' nem regisztrálva.");
        }

        $this->instances[$id] = ($this->services[$id])($this);
        return $this->instances[$id];
    }
}
