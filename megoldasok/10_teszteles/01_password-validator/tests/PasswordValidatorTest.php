<?php

use PHPUnit\Framework\TestCase;

class PasswordValidatorTest extends TestCase
{
    private PasswordValidator $validator;

    protected function setUp(): void
    {
        $this->validator = new PasswordValidator();
    }

    // --- Helyes bemenetek (true) ---

    public function testValidPasswordReturnsTrue(): void
    {
        // Arrange
        $password = 'Secret123!';

        // Act
        $result = $this->validator->validate($password);

        // Assert
        $this->assertTrue($result);
    }

    public function testAnotherValidPasswordReturnsTrue(): void
    {
        $this->assertTrue($this->validator->validate('MyP@ssw0rd'));
    }

    public function testLongValidPasswordReturnsTrue(): void
    {
        $this->assertTrue($this->validator->validate('Sup3r$ecurePassw0rd!'));
    }

    // --- Hibás bemenetek (false) ---

    public function testEmptyPasswordReturnsFalse(): void
    {
        $this->assertFalse($this->validator->validate(''));
    }

    public function testPasswordWithoutUppercaseReturnsFalse(): void
    {
        $this->assertFalse($this->validator->validate('secret123!'));
    }

    public function testPasswordWithoutNumberReturnsFalse(): void
    {
        $this->assertFalse($this->validator->validate('Secret!!!'));
    }

    public function testPasswordWithoutSpecialCharReturnsFalse(): void
    {
        $this->assertFalse($this->validator->validate('Secret123'));
    }

    public function testPasswordOnlyLettersReturnsFalse(): void
    {
        $this->assertFalse($this->validator->validate('SecretSecret'));
    }

    // --- Határesetek ---

    public function testExactly8CharactersWithAllRequirementsReturnsTrue(): void
    {
        // Pontosan 8 karakter: nagybetű + szám + speciális + 5 normál
        $this->assertTrue($this->validator->validate('Secret1!'));
    }

    public function test7CharactersReturnsFalse(): void
    {
        // 7 karakter – egy karakterrel kevesebb a minimuménál (minden más teljesül)
        $this->assertFalse($this->validator->validate('Sec1!ab'));
    }

    public function testMissingUppercaseBoundaryReturnsFalse(): void
    {
        // Minden más teljesül, csak a nagybetű hiányzik
        $this->assertFalse($this->validator->validate('secret1!long'));
    }

    public function testMissingNumberBoundaryReturnsFalse(): void
    {
        // Minden más teljesül, csak a szám hiányzik
        $this->assertFalse($this->validator->validate('Secret!!!'));
    }

    public function testMissingSpecialCharBoundaryReturnsFalse(): void
    {
        // Minden más teljesül, csak a speciális karakter hiányzik
        $this->assertFalse($this->validator->validate('Secret1234'));
    }
}
