<?php

use PHPUnit\Framework\TestCase;

class PasswordValidatorTest extends TestCase
{
    private PasswordValidator $validator;

    protected function setUp(): void
    {
        $this->validator = new PasswordValidator();
    }

    public function testValidPasswordReturnsTrue(): void
    {
        $this->assertTrue($this->validator->validate('Secret123!'));
    }

    public function testEmptyPasswordReturnsFalse(): void
    {
        $this->assertFalse($this->validator->validate(''));
    }

    public function testTooShortPasswordReturnsFalse(): void
    {
        $this->assertFalse($this->validator->validate('Sec1!ab'));
    }

    public function testMissingUppercaseReturnsFalse(): void
    {
        $this->assertFalse($this->validator->validate('secret123!'));
    }

    public function testMissingNumberReturnsFalse(): void
    {
        $this->assertFalse($this->validator->validate('Secret!!!'));
    }

    public function testMissingSpecialCharReturnsFalse(): void
    {
        $this->assertFalse($this->validator->validate('Secret123'));
    }

    public function testExactly8CharsWithAllRequirementsReturnsTrue(): void
    {
        $this->assertTrue($this->validator->validate('Secret1!'));
    }

    // --- Ékezetes jelszavak ---

    public function testAccentedUppercaseCountsAsUppercase(): void
    {
        // Az Á nagybetű, a hossz karakterben számít (8 karakter)
        $this->assertTrue($this->validator->validate('Árvíz1!x'));
    }

    public function testAccentedLetterIsNotSpecialCharacter(): void
    {
        // Nincs speciális karakter: az ékezetes betű nem számít annak
        $this->assertFalse($this->validator->validate('árvíztűrő1A'));
    }

    public function testLengthIsCountedInCharactersNotBytes(): void
    {
        // 7 karakter, de az ékezetek miatt 9 bájt
        $this->assertFalse($this->validator->validate('Árvíz1!'));
    }
}
