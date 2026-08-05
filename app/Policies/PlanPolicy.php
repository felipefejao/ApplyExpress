<?php

namespace App\Policies;

use App\Models\Plan;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PlanPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isSuperAdmin();
    }

    public function view(User $user, Plan $plan): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->isSuperAdmin();
    }

    public function update(User $user, Plan $plan): bool
    {
        return $user->isSuperAdmin();
    }

    public function delete(User $user, Plan $plan): bool
    {
        return $user->isSuperAdmin();
    }
}
