<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\UserProgressService;
use App\Models\User;
use App\Http\Resources\ProgressResource;

use Illuminate\Http\Request;

class UserProgressController extends Controller
{
    public function __construct(
        private UserProgressService $userProgressService
    ) {}

    public function meProgress(Request $request)
    {
        return new ProgressResource(
            $this->userProgressService->getProgress($request->user())
        );
    }

public function userProgress(User $user)
{
    return new ProgressResource(
        $this->userProgressService->getProgress($user)
    );
}
}