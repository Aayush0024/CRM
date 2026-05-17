<?php

namespace App\Policies;

use App\Models\Deal;
use App\Models\User;

class DealPolicy
{
    /**
     * Admins and managers see all deals.
     * Sales executives see deals assigned to them.
     * Support agents cannot access deals.
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdmin() || $user->isManager() || $user->isSalesExecutive();
    }

    public function view(User $user, Deal $deal): bool
    {
        if ($user->isAdmin() || $user->isManager()) {
            return true;
        }
        return $user->isSalesExecutive() && $deal->assigned_to === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isManager() || $user->isSalesExecutive();
    }

    public function update(User $user, Deal $deal): bool
    {
        if ($user->isAdmin() || $user->isManager()) {
            return true;
        }
        // Sales executive can manage their own deals
        return $user->isSalesExecutive() && $deal->assigned_to === $user->id;
    }

    public function delete(User $user, Deal $deal): bool
    {
        return $user->isAdmin() || $user->isManager();
    }

    public function updateStage(User $user, Deal $deal): bool
    {
        return $this->update($user, $deal);
    }
}
