<?php

namespace App\Core;

class Container
{
    private array $services  = [];
    private array $instances = [];

    public function set(string $id, callable $resolver): void
    {
        $this->services[$id] = $resolver;
        unset($this->instances[$id]);
    }

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
