<?php

namespace App\Services;

use App\Models\User;
use App\Models\Scenario;

class UserProgressService
{
    public function getProgress(User $user): array
    {
        $submissions = $user->submissions()
            ->with('scenario')
            ->get();

        $totalSubmissions = $submissions->count();

        $passedSubmissions = $submissions
            ->where('status', 'passed')
            ->count();

        $completedScenarios = $submissions
            ->where('status', 'passed')
            ->pluck('scenario_id')
            ->unique()
            ->count();

        $totalAttemptedScenarios = $submissions
            ->pluck('scenario_id')
            ->unique()
            ->count();

        $totalPoints = $submissions
            ->groupBy('scenario_id')
            ->map(function ($scenarioSubmissions) {
                return $scenarioSubmissions->max('score');
            })
            ->sum();

        $successRate = $totalAttemptedScenarios > 0
            ? round(($completedScenarios / $totalAttemptedScenarios) * 100, 2)
            : 0;

        $totalAvailableScenarios = Scenario::count();

        $overallProgressRate = $totalAvailableScenarios > 0
            ? round(($completedScenarios / $totalAvailableScenarios) * 100, 2)
            : 0;

        $scenarios = $submissions
            ->groupBy('scenario_id')
            ->map(function ($scenarioSubmissions) {
                $bestScore = $scenarioSubmissions->max('score');
                $bestSubmission = $scenarioSubmissions->sortByDesc('score')->first();

                return [
                    'scenario_id' => $bestSubmission->scenario->id,
                    'scenario_title' => $bestSubmission->scenario->title,
                    'status' => $scenarioSubmissions->contains('status', 'passed') ? 'passed' : 'failed',
                    'best_score' => $bestScore,
                    'attempts' => $scenarioSubmissions->count(),
                ];
            })
            ->values();

        return [
            'completed_scenarios' => $completedScenarios,
            'passed_submissions' => $passedSubmissions,
            'total_attempted_scenarios' => $totalAttemptedScenarios,
            'total_submissions' => $totalSubmissions,
            'scenarios' => $scenarios,
            'failed_submissions' => $submissions->where('status', 'failed')->count(),
            'total_points' => $totalPoints,
            'success_rate' => $successRate,
            'overall_progress_rate' => $overallProgressRate,
        ];
    }
}