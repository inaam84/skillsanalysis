<?php
declare(strict_types = 1);

namespace src;

use DateTime;
use InvalidArgumentException;

class SkillsAnalysisNonDL extends SkillsAnalysis
{
    public function __construct(Learner $learner, array $questions)
    {
        parent::__construct($learner, $questions);
    }

    private function getExistingKnowledgePercentage(): float
    {
        $scoresCount = [
            2 => 0,
            3 => 0,
            4 => 0,
            5 => 0,
        ];
        foreach($this->questions AS $question)
        {
            $score = $question->getScore();
            if(isset($scoresCount[$score]))
            {
                $scoresCount[$score]++;
            }
        }

        $percentage = $scoresCount[2] * 0.025 + 
            $scoresCount[3] * 0.050 + 
            $scoresCount[4] * 0.10 + 
            $scoresCount[5] * 0.15;

        return $percentage;
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