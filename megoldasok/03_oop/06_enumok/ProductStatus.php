<?php

enum ProductStatus: string
{
    case Active       = 'active';
    case Inactive     = 'inactive';
    case Discontinued = 'discontinued';

    public function label(): string
    {
        return match($this) {
            self::Active       => 'Aktív',
            self::Inactive     => 'Inaktív',
            self::Discontinued => 'Megszüntetett',
        };
    }
}
