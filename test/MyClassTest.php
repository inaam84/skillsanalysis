<?php
declare(strict_types = 1);

namespace src;
use src\Question;

use PHPUnit\Framework\TestCase;

class MyClassTest extends TestCase
{
    private $myClass;

    public function setUp(): void
    {
        $this->myClass = new MyClass();
    }

    /**
     * @dataProvider concatenationDataProvider
     */
    
    public function testConcatenateString(string $str1, string $str2, string $expected): void
    {
        $result = $this->myClass->concatenateString($str1, $str2);

        $this->assertEquals($expected, $result);
    }

    public static function concatenationDataProvider(): array
    {
        return [
            ['hello', 'world', 'helloworld'],
            ['foo', 'bar', 'foobar'],
            ['', '', ''],
        ];
    }

    public function testUln(): void
    {
        $uln = ULNGenerator::generate();

        $this->assertEquals(10, strlen($uln));

        $this->assertNotEquals(0, (int) $uln[0]);

        $this->assertNotEquals(0, (int) $uln[9]);

        $checkDigit = ULNGenerator::calculateCheckDigit($uln);

        $this->assertNotEquals(10, $checkDigit);

        $this->assertEquals((int) $checkDigit, (int) $uln[9]);
    }

    public function testCalculateCheckDigit(): void
    {
        $uln1 = "3659656622";

        $checkDigit = ULNGenerator::calculateCheckDigit( substr($uln1, 0, 9) );
        $this->assertEquals(2, $checkDigit);
    }

    public function testNINOValidator(): void
    {
        $nino = "QQ 12 34 56 A";
        $this->assertFalse(NINOValidator::validate($nino));

        $nino = "JX048934B";
        $this->assertTrue(NINOValidator::validate($nino));

        $nino = "JO048934B";
        $this->assertFalse(NINOValidator::validate($nino));

        $nino = "JB048934Z";
        $this->assertFalse(NINOValidator::validate($nino));

        $nino = "BG745786B";
        $this->assertFalse(NINOValidator::validate($nino));
    }

    public function testNINOGenerator(): void
    {
        $nino = NINOValidator::generate();
        $this->assertTrue(NINOValidator::validate($nino));
    }
}