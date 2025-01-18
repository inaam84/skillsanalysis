<?php
declare(strict_types = 1);

use PHPUnit\Framework\TestCase;
use src\Question;

class QuestionTest extends TestCase
{
    protected Question $question;

    public function setUp(): void
    {
        $this->question = new Question(1, 'PHP Knowledge', 4.5, 3);
    }

    public function testId(): void
    {
        $this->assertEquals(1, $this->question->getId());
    }

    public function testText(): void
    {
        $this->assertEquals('PHP Knowledge', $this->question->getText());
    }

    public function testInvalidScore(): void
    {
        $this->expectException('InvalidArgumentException');
        $this->expectExceptionMessage('Score must be between 1 and 5');

        $this->question->setScore(10);
    }

    public function testScore(): void
    {
        $this->assertEquals(3, $this->question->getScore());
    }
}