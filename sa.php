<?php

include('vendor/autoload.php');

use src\Learner;
use src\Question;
use src\SkillsAnalysisDL;
use src\SkillsAnalysisFactory;
use src\SkillsAnalysisService;

$learner = new Learner(1, 'Joe Bloggs', new DateTime('2025-01-01'), new DateTime('2025-12-31'));

$questions = [];
foreach(range(1, 49) AS $i)
{
    $questions[] = new Question($i, "ABC", 5, 3);
}

$skillsAnalysis = SkillsAnalysisFactory::create('DL', $learner, $questions);
$service = new SkillsAnalysisService($skillsAnalysis);
$newEndDate = $service->getNewPlannedEndDate();
echo $newEndDate->format('d/m/Y') . "\n";
$priceReduction = $service->getPriceRange();
echo "Price Reduction Range: Min - " . $priceReduction['minReduction'] . "%, Max - " . $priceReduction['maxReduction'] . "%\n";


$skillsAnalysis = SkillsAnalysisFactory::create('NON_DL', $learner, $questions);
$service = new SkillsAnalysisService($skillsAnalysis);
$newEndDate = $service->getNewPlannedEndDate();
echo $newEndDate->format('d/m/Y') . "\n";
$priceReduction = $service->getPriceRange();
echo "Price Reduction Range: Min - " . $priceReduction['minReduction'] . "%, Max - " . $priceReduction['maxReduction'] . "%\n";
