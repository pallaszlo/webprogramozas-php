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
}
