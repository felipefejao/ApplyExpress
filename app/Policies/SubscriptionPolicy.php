<?php

namespace App\Policies;

use App\Models\Subscription;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SubscriptionPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isSuperAdmin();
    }

    public function view(User $user, Subscription $subscription): bool
    {
        return $user->isSuperAdmin() || $subscription->user_id === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->isSuperAdmin();
    }

    public function update(User $user, Subscription $subscription): bool
    {
        return $user->isSuperAdmin();
    }

    public function delete(User $user, Subscription $subscription): bool
    {
        return $user->isSuperAdmin();
    }
}
