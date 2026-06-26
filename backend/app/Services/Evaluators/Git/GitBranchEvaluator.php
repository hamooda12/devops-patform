<?php

namespace App\Services\Evaluators\Git;

use App\Models\Scenario;
use App\Models\Submission;
use App\Services\Evaluators\EvaluatorInterface;
class GitBranchEvaluator implements EvaluatorInterface
{
    public function evaluate(Scenario $scenario, Submission $submission): array
    {
        $output = $submission->command_output;

        if (str_contains($output, 'git branch') && str_contains($output, 'git checkout')) {
            return [
                'score' => 100,
                'status' => 'passed',
                'feedback' => 'Great! You created a new git branch and switched to it.',
            ];
        }

        return [
            'score' => 0,
            'status' => 'failed',
            'feedback' => 'You need to run git branch and git checkout.',
        ];
    }
}