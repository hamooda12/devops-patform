<?php

namespace App\Services\Terminal;

use App\Services\Docker\DockerRunnerInterface;
use Illuminate\Support\Facades\Cache;

class TerminalSessionManager
{
    public function __construct(
        private DockerRunnerInterface $runner
    ) {}

    public function create(int $userId, int $scenarioId): array
    {
        $containerName = $this->runner->createContainer();

        $sessionId = 'terminal_' . uniqid();

        Cache::put($this->cacheKey($sessionId), [
            'user_id' => $userId,
            'scenario_id' => $scenarioId,
            'container_name' => $containerName,
        ], now()->addMinutes(30));

        return [
            'session_id' => $sessionId,
            'container_name' => $containerName,
        ];
    }

    public function execute(string $sessionId, string $commands): array
    {
        $session = Cache::get($this->cacheKey($sessionId));

        if (! $session) {
            return [
                'success' => false,
                'output' => '',
                'error' => 'Terminal session not found or expired.',
                'exit_code' => 1,
            ];
        }

        return $this->runner->exec($session['container_name'], $commands);
    }

    public function destroy(string $sessionId): void
    {
        $session = Cache::get($this->cacheKey($sessionId));

        if ($session) {
            $this->runner->removeContainer($session['container_name']);
            Cache::forget($this->cacheKey($sessionId));
        }
    }

    public function get(string $sessionId): ?array
    {
        return Cache::get($this->cacheKey($sessionId));
    }

    private function cacheKey(string $sessionId): string
    {
        return 'terminal_session:' . $sessionId;
    }
}