<?php

namespace App\Services;

use App\Models\Scenario;
use App\Models\Submission;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AdminDashboardService
{
    public function getDashboardData(): array
    {
        $totalUsers = User::count();
        $totalScenarios = Scenario::count();
        $totalSubmissions = Submission::count();

        $passedSubmissions = Submission::where('status', 'passed')->count();
        $failedSubmissions = Submission::where('status', 'failed')->count();

        $completionRate = $totalSubmissions > 0
            ? round(($passedSubmissions / $totalSubmissions) * 100, 2)
            : 0;

        $topUsers = User::withSum('submissions as total_points', 'score')
            ->withCount([
                'submissions as completed_scenarios' => function ($query) {
                    $query->where('status', 'passed');
                }
            ])
            ->orderByDesc('total_points')
            ->take(5)
            ->get(['id', 'name', 'email']);

        $recentSubmissions = Submission::with([
                'user:id,name,email',
                'scenario:id,title,slug,difficulty,type,points'
            ])
            ->latest()
            ->take(10)
            ->get();

        $submissionsPerDay = Submission::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as total')
            )
            ->where('created_at', '>=', now()->subDays(6))
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date')
            ->get();

        $mostFailedScenarios = Scenario::withCount([
                'submissions as failed_count' => function ($query) {
                    $query->where('status', 'failed');
                }
            ])
            ->orderByDesc('failed_count')
            ->take(5)
            ->get(['id', 'title', 'slug', 'difficulty', 'type']);

        $latestUsers = User::latest()
            ->take(5)
            ->get(['id', 'name', 'email', 'created_at']);

        return [
            'cards' => [
                'users' => $totalUsers,
                'scenarios' => $totalScenarios,
                'submissions' => $totalSubmissions,
                'passed_submissions' => $passedSubmissions,
                'failed_submissions' => $failedSubmissions,
                'completion_rate' => $completionRate,
            ],

            'top_users' => $topUsers,
            'recent_submissions' => $recentSubmissions,
            'submissions_per_day' => $submissionsPerDay,
            'most_failed_scenarios' => $mostFailedScenarios,
            'latest_users' => $latestUsers,
        ];
    }
}