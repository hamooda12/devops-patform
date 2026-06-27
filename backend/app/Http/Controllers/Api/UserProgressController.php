<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\UserProgressService;
use Illuminate\Http\Request;

class UserProgressController extends Controller
{
    public function __construct(
        private UserProgressService $userProgressService
    ) {}

    public function meProgress(Request $request)
    {
        return response()->json([
            'data' => $this->userProgressService->getProgress($request->user())
        ]);
    }
}