<?php

// =============================================================
// 9.21. DI Container osztály
// =============================================================

namespace App\Core;

class Container
{
    private array $services = [];
    private array $instances = [];

    // Service regisztrálása closure-rel
    public function set(string $id, callable $resolver): void
    {
        $this->services[$id] = $resolver;
        unset($this->instances[$id]);
    }

    // Service lekérése (caching)
    public function get(string $id): mixed
    {
        // Ha már van instance, adjuk vissza azt
        if (isset($this->instances[$id])) {
            return $this->instances[$id];
        }

        if (!isset($this->services[$id])) {
            throw new \RuntimeException(
                "Service '{$id}' nem regisztrálva."
            );
        }

        // Service factory meghívása és caching
        $this->instances[$id] = ($this->services[$id])($this);

        return $this->instances[$id];
    }
}
