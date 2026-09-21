<?php

// Kiegészítés (nem szerepel a könyvben): egy egyszerű teszt a "composer test"
// kipróbálásához. A PHPUnit-tesztekről a 10. fejezet szól.

use PHPUnit\Framework\TestCase;

class PeldaTest extends TestCase
{
    public function testOsszeadas(): void
    {
        $this->assertSame(4, 2 + 2);
    }
}
