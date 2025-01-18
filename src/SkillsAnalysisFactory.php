<?php
declare(strict_types = 1);

namespace src;

use InvalidArgumentException;

class SkillsAnalysisFactory
{
    /**
     * Create an instance of the appropriate SkillsAnalysis subclass.
     *
     * @param string $type The type of skills analysis (e.g., 'DL' or 'NON_DL').
     * @param Learner $learner The learner object.
     * @param array $questions Array of Question objects.
     * @return ISkillsAnalysis
     * @throws InvalidArgumentException
     */
    public static function create(string $type, Learner $learner, array $questions): ISkillsAnalysis
    {
        switch($type)
        {
            case "DL":
                return new SkillsAnalysisDL($learner, $questions);
            case "NON_DL":
                return new SkillsAnalysisNonDL($learner, $questions);
            default:
                throw new InvalidArgumentException("Invalid skills analysis type: {$type}");
        }
    }
}