<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\UserProgressService;
use Illuminate\Http\Request;
use App\Filters\UserFilter;

class AdminUserController extends Controller
{
    public function __construct(
        private UserProgressService $userProgressService
    ) {}

   public function index(Request $request, UserFilter $filter)
{
    $users = $filter
        ->apply(User::query(), $request)
        ->paginate($request->get('per_page', 10));

    return response()->json([
        'data' => $users,
    ]);
}

    public function show(User $user)
    {
        return response()->json([
            'data' => [
                'user' => $user,
                'progress' => $this->userProgressService->getProgress($user)
            ]
        ]);
    }
    public function updateRole(Request $request, User $user)
{
     if ($request->user()->id === $user->id) {
        return response()->json([
            'message' => 'You cannot change your own role',
        ], 403);
    }
    $data = $request->validate([
        'role' => 'required|in:user,admin',
    ]);

    $user->update([
        'role' => $data['role'],
    ]);

    return response()->json([
        'message' => 'Role updated successfully',
        'data' => $user,
    ]);
}
    
}