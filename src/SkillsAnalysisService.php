<?php
declare(strict_types = 1);

namespace src;


class SkillsAnalysisService
{
    protected ISkillsAnalysis $skillsAnalysis;

    public function __construct(ISkillsAnalysis $skillsAnalysis)
    {
        $this->skillsAnalysis = $skillsAnalysis;
    }

    public function getNewPlannedEndDate()
    {
        return $this->skillsAnalysis->getReducedEndDate();
    }

    public function getPriceRange()
    {
        return $this->skillsAnalysis->getPriceReductionRange();
    }
}