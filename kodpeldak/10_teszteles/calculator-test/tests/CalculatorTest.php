<?php

use PHPUnit\Framework\TestCase;

class CalculatorTest extends TestCase
{
    private Calculator $calculator;

    protected function setUp(): void
    {
        $this->calculator = new Calculator();
    }

    public function testAdd(): void
    {
        $result = $this->calculator->add(5, 3);
        $this->assertEquals(8, $result);
    }

    public function testSubtract(): void
    {
        $result = $this->calculator->subtract(10, 4);
        $this->assertEquals(6, $result);
    }

    public function testMultiply(): void
    {
        $result = $this->calculator->multiply(4, 7);
        $this->assertEquals(28, $result);
    }

    public function testDivide(): void
    {
        $result = $this->calculator->divide(15, 3);
        $this->assertEquals(5.0, $result);
    }

    public function testDivideByZeroThrowsException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->calculator->divide(10, 0);
    }
}
