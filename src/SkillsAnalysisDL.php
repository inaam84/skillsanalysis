<?php
declare(strict_types = 1);

namespace src;

use DateTime;
use InvalidArgumentException;

class SkillsAnalysisDL extends SkillsAnalysis
{
    public function __construct(Learner $learner, array $questions)
    {
        parent::__construct($learner, $questions);
    }

    public function getTotalDeliveryHoursBeforeReduction(): float
    {
        $total = 0;
        foreach($this->questions AS $question)
        {
            $total += $question->getFullDeliveryHours();
        }

        return $total;
    }

    public function getTotalDeliveryHoursAfterReduction(): float
    {
        $total = 0;
        foreach($this->questions AS $question)
        {
            $total += $this->getQuestionReducedDeliveryHours($question);
        }

        return $total;
    }

    private function getQuestionReducedDeliveryHours(Question $question): float
    {
        $deliveryHours = $question->getFullDeliveryHours();
        $score = $question->getScore();

        if($score === null)
        {
            return $deliveryHours;
        }

        switch($score)
        {
            case 3:
                return $deliveryHours * 0.75;
            case 4:
                return $deliveryHours * 0.5;
            case 5:
                return $deliveryHours * 0.25;
            default:
                return $deliveryHours;
        }
    }

    private function getExistingKnowledgePercentage(): float
    {
        $beforeReduction = $this->getTotalDeliveryHoursBeforeReduction();
        $afterReduction = $this->getTotalDeliveryHoursAfterReduction();

        if($beforeReduction == 0)
        {
            return 0;
        }

        return 100 - round(($afterReduction / $beforeReduction) * 100, 2);
    }

    public function getPriceReductionRange(): array
    {
        $knowledgePercentage = $this->getExistingKnowledgePercentage();

        // min reduction is 50% of the saved percentage
        $minReduction = $knowledgePercentage * 0.5;

        // max reduction is full saved percentage
        $maxReduction = $knowledgePercentage;

        return [
            'minReduction' => round($minReduction, 2),
            'maxReduction' => round($maxReduction, 2),
        ];
    }

    public function getReducedEndDate(): DateTime
    {
        $knowledgePercentage = $this->getExistingKnowledgePercentage();

        $startDate = $this->learner->getStartDate();
        $endDate = $this->learner->getEndDate();

        $duration = $startDate->diff($endDate);
        $reductionFactor = $knowledgePercentage / 100;

        $reducedDays = (int) ($duration->days * (1 - $reductionFactor));

        $newEndDate = clone $startDate;
        $newEndDate->modify("+{$reducedDays} days");

        return $newEndDate;
    }
}