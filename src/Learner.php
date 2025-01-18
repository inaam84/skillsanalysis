<?php
declare(strict_types = 1);

namespace src;

use DateTime;

class Learner
{
    public function __construct(
        protected int $id, 
        protected string $name,
        protected DateTime $startDate,
        protected DateTime $endDate
    )
    {
        
    }

    public function getStartDate(): DateTime
    {
        return $this->startDate;
    }

    public function getEndDate(): DateTime
    {
        return $this->endDate;
    }
}