<?php

namespace App\Services\Evaluators;

use App\Models\Scenario;
use App\Models\Submission;

class GitInitEvaluator implements EvaluatorInterface
{
    public function evaluate(Scenario $scenario, Submission $submission): array
    {
        $output = $submission->command_output;

        if (str_contains($output, 'git init') && str_contains($output, 'git commit')) {
            return [
                'score' => 100,
                'status' => 'passed',
                'feedback' => 'Great! You initialized git and created a commit.',
            ];
        }

        return [
            'score' => 0,
            'status' => 'failed',
            'feedback' => 'You need to run git init and create an initial commit.',
        ];
    }
}