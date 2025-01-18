<?php
declare(strict_types = 1);

namespace src;

use DateTime;
use InvalidArgumentException;

abstract class SkillsAnalysis implements ISkillsAnalysis
{
    protected Learner $learner;
    protected array $questions = [];

    public function __construct(Learner $learner, array $questions)
    {
        $this->learner = $learner;
        foreach($questions AS $question)
        {
            if(!$question instanceof Question)
            {
                throw new InvalidArgumentException('Each element in the questions array must be an instance of Question class');
            }
            $this->questions[$question->getId()] = $question;
        }
    }

    public function getQuestions(): array
    {
        return $this->questions;
    }

    public function answerQuestion(int $questionId, int $score): void
    {
        if(!isset($this->questions[$questionId]))
        {
            throw new InvalidArgumentException('Question not found');
        }

        $this->questions[$questionId]->setScore($score);
    }
}