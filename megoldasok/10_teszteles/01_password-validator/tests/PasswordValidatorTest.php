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
        // Pontosan 8 karakter: nagybetű + szám + speciális + 5 kisbetű
        $this->assertTrue($this->validator->validate('Secret1!'));
    }

    public function test7CharactersReturnsFalse(): void
    {
        // 7 karakter – egy karakterrel kevesebb a minimumnál (minden más teljesül)
        $this->assertFalse($this->validator->validate('Sec1!ab'));
    }

    public function testMissingUppercaseBoundaryReturnsFalse(): void
    {
        // Minden más teljesül, csak a nagybetű hiányzik
        $this->assertFalse($this->validator->validate('secret1!long'));
    }

    public function testMissingNumberBoundaryReturnsFalse(): void
    {
        // Minden más teljesül (hosszabb jelszó), csak a szám hiányzik
        $this->assertFalse($this->validator->validate('Secret!!!long'));
    }

    public function testMissingSpecialCharBoundaryReturnsFalse(): void
    {
        // Minden más teljesül, csak a speciális karakter hiányzik
        $this->assertFalse($this->validator->validate('Secret1234'));
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
