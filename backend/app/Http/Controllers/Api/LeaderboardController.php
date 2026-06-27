<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\LeaderboardService;

class LeaderboardController extends Controller
{
    public function __construct(
        private LeaderboardService $leaderboardService
    ) {}

    public function index()
    {
        return response()->json([
            'data' => $this->leaderboardService->getLeaderboard()
        ]);
    }
}