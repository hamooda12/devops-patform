<?php

namespace App\Services\Evaluators;

use App\Models\Scenario;
use App\Models\Submission;
use App\Services\Evaluators\GitInitEvaluator;
use App\Services\Evaluators\EvaluatorFactory;
class GitEvaluator implements EvaluatorInterface
{
public function evaluate(Scenario $scenario, Submission $submission): array
    {
        return match ($scenario->slug) {
            'git-init' => (new GitInitEvaluator())->evaluate($scenario, $submission),
            default => throw new \Exception('No evaluator found for this scenario'),
        };
    }

}