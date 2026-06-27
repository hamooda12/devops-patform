<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\LeaderboardService;
use App\Http\Resources\LeaderboardResource;
class LeaderboardController extends Controller
{
    public function __construct(
        private LeaderboardService $leaderboardService
    ) {}

 public function index()
{
    return LeaderboardResource::collection(
        $this->leaderboardService->getLeaderboard()
    );
}
}