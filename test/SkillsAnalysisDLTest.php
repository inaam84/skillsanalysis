<?php
declare(strict_types = 1);

use PHPUnit\Framework\TestCase;
use src\Learner;
use src\Question;
use src\SkillsAnalysisDL;

class SkillsAnalysisDLTest extends TestCase
{
    protected SkillsAnalysisDL $sa;

    public function setUp(): void
    {
        $learner = $this->createLearner(
            1, 
            'Joe Bloggs', 
            new DateTime('2025-01-01'), 
            new DateTime('2025-12-31')
        );

        $questions = [
            $this->createQuestion(1, "Understanding of PHP Basics", 5, 3),
            $this->createQuestion(2, "Understanding of OOP", 5, 3),
            $this->createQuestion(3, "Ability to write code", 5, 3),
        ];

        $this->sa = new SkillsAnalysisDL($learner, $questions);
    }

    private function createLearner(int $id, string $name, DateTime $startDate, DateTime $endDate)
    {
        $learner = $this->getMockBuilder(Learner::class)
            ->setConstructorArgs([$id, $name, $startDate, $endDate])
            ->onlyMethods(['getStartDate', 'getEndDate'])
            ->getMock();

        $learner->method('getStartDate')->willReturn($startDate);
        $learner->method('getEndDate')->willReturn($endDate);

        return $learner;
    }

    private function createQuestion(int $id, string $text, float $deliveryHours, int $score)
    {
        $question = $this->getMockBuilder(Question::class)
            ->setConstructorArgs([$id, $text, $deliveryHours, $score])
            ->onlyMethods(['getId', 'getScore', 'getFullDeliveryHours'])
            ->getMock();

        $question->method('getId')->willReturn($id);
        $question->method('getFullDeliveryHours')->willReturn($deliveryHours);
        $question->method('getScore')->willReturn($score);

        return $question;
    }

    public function testQuestions(): void
    {
        $this->assertCount(3, $this->sa->getQuestions());
    }

    public function testAnswerQuestion(): void
    {
        $this->sa->answerQuestion(1, 4);
        $this->addToAssertionCount(1);
    }

    public function testTotalDeliveryHoursBeforeReduction(): void
    {
        $this->assertEquals(15, $this->sa->getTotalDeliveryHoursBeforeReduction());
    }

    public function testTotalDeliveryHoursAfterReduction(): void
    {
        $this->assertEquals(11.25, $this->sa->getTotalDeliveryHoursAfterReduction());
    }

    public function testPriceReductionRange(): void
    {
        $actualRange = $this->sa->getPriceReductionRange();
        $this->assertCount(2, $actualRange);
        $this->assertArrayHasKey('minReduction', $actualRange);
        $this->assertArrayHasKey('maxReduction', $actualRange);
        $this->assertEquals(12.5, $actualRange['minReduction']);
        $this->assertEquals(25, $actualRange['maxReduction']);
    }

    public function testReducedEndDate(): void
    {
        $this->assertEquals('01/10/2025', $this->sa->getReducedEndDate()->format('d/m/Y'));
    }
}