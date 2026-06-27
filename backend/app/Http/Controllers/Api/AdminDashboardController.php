<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\AdminDashboardService;
use App\Http\Resources\AdminDashboardResource;
class AdminDashboardController extends Controller
{
    public function __construct(
        private AdminDashboardService $adminDashboardService
    ) {}

 public function index()
{
    return new AdminDashboardResource(
        $this->adminDashboardService->getDashboardData()
    );
}
}