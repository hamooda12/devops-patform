<?php

namespace App\Services;

use App\Models\User;

class LeaderboardService
{
    public function getLeaderboard()
    {
        $users = User::with(['submissions.scenario'])->get();

        return $users->map(function ($user) {
            $submissions = $user->submissions;

            $totalPoints = $submissions
                ->groupBy('scenario_id')
                ->map(function ($scenarioSubmissions) {
                    return $scenarioSubmissions->max('score');
                })
                ->sum();

            $completedScenarios = $submissions
                ->where('status', 'passed')
                ->pluck('scenario_id')
                ->unique()
                ->count();

            return [
                'user_id' => $user->id,
                'name' => $user->name,
                'total_points' => $totalPoints,
                'completed_scenarios' => $completedScenarios,
            ];
        })
        ->sortByDesc('total_points')
        ->values();
    }
}