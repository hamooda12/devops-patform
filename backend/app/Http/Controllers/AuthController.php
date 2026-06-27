<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\Scenario;
class AuthController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

       

        return response()->json([
            'message' => 'Registered successfully',
            'user' => $user,
          
        ], 201);
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $data['email'])->first();

        if (! $user || ! Hash::check($data['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Invalid credentials'],
            ]);
        }

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'message' => 'Logged in successfully',
            'user' => $user,
            'token' => $token,
        ]);
    }

    public function me(Request $request)
    {
        return response()->json($request->user());
    }
    public function meProgress(Request $request)
{
    $user = $request->user();

    $submissions = $user->submissions()
        ->with('scenario')
        ->get();

    $totalSubmissions = $submissions->count();
    $passedSubmissions = $submissions->where('status', 'passed')->count();
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
    return response()->json([
        'data' => [
            'completed_scenarios' => $completedScenarios,
            'passed_submissions' => $passedSubmissions,
            'total_attempted_scenarios' => $totalAttemptedScenarios,
'total_submissions' => $totalSubmissions,
           'scenarios' => $submissions
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
    ->values(),
            'passed_submissions' => $passedSubmissions,
            'failed_submissions' => $submissions->where('status', 'failed')->count(),
            'total_points' => $totalPoints,

            'success_rate' => $successRate,
            'overall_progress_rate' => $overallProgressRate,
        ],
    ]);
}
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully',
        ]);
    }
}