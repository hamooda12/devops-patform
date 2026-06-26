<?php

namespace App\Services\Evaluators;

use App\Models\Scenario;
use App\Models\Submission;
use App\Services\Evaluators\Git\gitEvaluator;
use App\Services\Evaluators\EvaluatorFactoryInterface;

class EvaluatorFactory implements EvaluatorFactoryInterface
{
    public function getEvaluator(Scenario $scenario): EvaluatorInterface
    {
        return match ($scenario->type) {
            'git' => new GitEvaluator(),
            default => throw new \Exception('No evaluator found for this scenario type'),
        };
    }
   
}