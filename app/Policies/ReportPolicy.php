<?php

namespace App\Policies;

use App\Models\User;

class ReportPolicy
{
    /**
     * Only admins and managers can view reports.
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdmin() || $user->isManager();
    }
}
