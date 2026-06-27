<?php

namespace App\Policies;

use App\Models\Scenario;
use App\Models\User;

class ScenarioPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Scenario $scenario): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->role === 'admin';
    }

    public function update(User $user, Scenario $scenario): bool
    {
        return $user->role === 'admin';
    }

    public function delete(User $user, Scenario $scenario): bool
    {
        return $user->role === 'admin';
    }
}