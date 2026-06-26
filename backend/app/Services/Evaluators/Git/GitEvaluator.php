<?php

namespace App\Services\Evaluators\Git;

use App\Models\Scenario;
use App\Models\Submission;
use App\Services\Evaluators\EvaluatorInterface;
class GitEvaluator implements EvaluatorInterface
{
public function evaluate(Scenario $scenario, Submission $submission): array
    {
        return match ($scenario->slug) {
            'git-init' => (new GitInitEvaluator())->evaluate($scenario, $submission),
            'git-branch-create' => (new GitBranchEvaluator())->evaluate($scenario, $submission),
            default => throw new \Exception('No evaluator found for this scenario'),
        };
    }

}