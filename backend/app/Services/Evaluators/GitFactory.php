<?php

namespace App\Services\Evaluators;

use App\Models\Scenario;
use App\Models\Submission;
use App\Services\Evaluators\GitInitEvaluator;


class GitFactoryEvaluator 
{
    public function getEvaluator(Scenario $scenario): EvaluatorInterface
    {
        return match ($scenario->slug) {
            'git-init' => new GitInitEvaluator(),
            default => throw new \Exception('No evaluator found for this scenario'),
        };
    }
   
}