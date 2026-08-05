<?php

namespace App\Policies;

use App\Models\CreditTransaction;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CreditTransactionPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isSuperAdmin();
    }

    public function view(User $user, CreditTransaction $creditTransaction): bool
    {
        return $user->isSuperAdmin() || $creditTransaction->user_id === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->isSuperAdmin();
    }

    public function update(User $user, CreditTransaction $creditTransaction): bool
    {
        return $user->isSuperAdmin();
    }

    public function delete(User $user, CreditTransaction $creditTransaction): bool
    {
        return $user->isSuperAdmin();
    }
}
