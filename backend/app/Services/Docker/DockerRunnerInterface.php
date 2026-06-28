<?php

namespace App\Services\Docker;

interface DockerRunnerInterface
{
    public function createContainer(): string;

    public function exec(string $containerName, string $commands): array;

    public function removeContainer(string $containerName): void;
}