<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\UserProgressService;
    use App\Models\User;

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

public function userProgress(User $user)
{
    return response()->json([
        'data' => $this->userProgressService->getProgress($user)
    ]);
}
}