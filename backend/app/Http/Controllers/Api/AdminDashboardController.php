<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\AdminDashboardService;

class AdminDashboardController extends Controller
{
    public function __construct(
        private AdminDashboardService $adminDashboardService
    ) {}

    public function index()
    {
        return response()->json([
            'data' => $this->adminDashboardService->getDashboardData()
        ]);
    }
}