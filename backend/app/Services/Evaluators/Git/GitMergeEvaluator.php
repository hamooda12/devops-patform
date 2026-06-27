<?php

namespace App\Services\Evaluators\Git;

use App\Models\Scenario;
use App\Models\Submission;
use App\Services\Evaluators\EvaluatorInterface;
class GitMergeEvaluator implements EvaluatorInterface
{
    public function evaluate(Scenario $scenario, Submission $submission): array
    {
        $output = $submission->command_output;
$hasSwitchToMain =
    str_contains($output, 'git checkout main') ||
    str_contains($output, 'git switch main');

$hasMerge = str_contains($output, 'git merge feature/login');

if ($hasSwitchToMain && $hasMerge) {
    return [
        'score' => 100,
        'status' => 'passed',
        'feedback' => 'Great! You switched to main and merged feature/login.',
    ];}

       

        return [
            'score' => 0,
            'status' => 'failed',
            'feedback' => 'You need to run git merge to merge the branches  .',
        ];
    }
}