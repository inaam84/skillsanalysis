<?php

namespace src;

use DateTime;

interface ISkillsAnalysis
{
    public function getReducedEndDate(): DateTime;

    public function getPriceReductionRange(): array;
}