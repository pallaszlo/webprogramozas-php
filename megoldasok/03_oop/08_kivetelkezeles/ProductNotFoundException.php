<?php

class ProductNotFoundException extends RuntimeException
{
    public function __construct(string $name)
    {
        parent::__construct("A termék nem található: \"{$name}\".");
    }
}
