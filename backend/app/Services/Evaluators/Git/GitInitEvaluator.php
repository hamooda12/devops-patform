<?php

namespace App\Services\Evaluators\Git;

use App\Models\Scenario;
use App\Models\Submission;
use App\Services\Docker\DockerRunnerInterface;
use App\Services\Evaluators\EvaluatorInterface;

class GitInitEvaluator implements EvaluatorInterface
{
    public function evaluate(Scenario $scenario, Submission $submission): array
    {
        $runner = app(DockerRunnerInterface::class);

        $containerName = $runner->createContainer();

        try {
            $runner->exec($containerName, $submission->command_output);

            $gitCheck = $runner->exec($containerName, 'test -d .git');
            $commitCheck = $runner->exec($containerName, 'git log --oneline');

            if (! $gitCheck['success']) {
                return [
                    'score' => 0,
                    'status' => 'failed',
                    'feedback' => 'You need to initialize a Git repository using git init.',
                ];
            }

            if (! $commitCheck['success'] || trim($commitCheck['output']) === '') {
                return [
                    'score' => 50,
                    'status' => 'failed',
                    'feedback' => 'Git repository initialized, but you still need to create an initial commit.',
                ];
            }

            return [
                'score' => 100,
                'status' => 'passed',
                'feedback' => 'Great job! You initialized a Git repository and created an initial commit.',
            ];
        } finally {
            $runner->removeContainer($containerName);
        }
    }
}