<?php

namespace App\Services\Docker;

use Symfony\Component\Process\Process;

class DockerCliRunner implements DockerRunnerInterface
{
    public function createContainer(): string
    {
        $name = 'devops_eval_' . uniqid();

        $process = new Process([
            'docker',
            'run',
            '-dit',
            '--name', $name,
            '--network', 'none',
            '--memory', '128m',
            '--cpus', '0.5',
            'devops-evaluator:latest',
            'bash',
        ]);

        $process->setTimeout(20);
        $process->run();

        if (! $process->isSuccessful()) {
            throw new \Exception($process->getErrorOutput());
        }

        return $name;
    }

    public function exec(string $containerName, string $commands): array
    {
        $process = new Process([
            'docker',
            'exec',
            $containerName,
            'bash',
            '-c',
            "
            cd /workspace &&
            $commands
            "
        ]);

        $process->setTimeout(20);
        $process->run();

        return [
            'success' => $process->isSuccessful(),
            'output' => $process->getOutput(),
            'error' => $process->getErrorOutput(),
            'exit_code' => $process->getExitCode(),
        ];
    }

    public function removeContainer(string $containerName): void
    {
        $process = new Process([
            'docker',
            'rm',
            '-f',
            $containerName,
        ]);

        $process->setTimeout(10);
        $process->run();
    }
}