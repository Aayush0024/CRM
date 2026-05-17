<?php

namespace App\Policies;

use App\Models\Lead;
use App\Models\User;

class LeadPolicy
{
    /**
     * Admins and managers see all leads.
     * Sales executives only see leads assigned to them.
     * Support agents cannot access leads.
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdmin() || $user->isManager() || $user->isSalesExecutive();
    }

    public function view(User $user, Lead $lead): bool
    {
        if ($user->isAdmin() || $user->isManager()) {
            return true;
        }
        // Sales executive can only view their own leads
        return $user->isSalesExecutive() && $lead->assigned_to === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isManager() || $user->isSalesExecutive();
    }

    public function update(User $user, Lead $lead): bool
    {
        if ($user->isAdmin() || $user->isManager()) {
            return true;
        }
        // Sales executive can only update their own leads
        return $user->isSalesExecutive() && $lead->assigned_to === $user->id;
    }

    public function delete(User $user, Lead $lead): bool
    {
        return $user->isAdmin() || $user->isManager();
    }

    public function convert(User $user, Lead $lead): bool
    {
        if ($user->isAdmin() || $user->isManager()) {
            return true;
        }
        return $user->isSalesExecutive() && $lead->assigned_to === $user->id;
    }
}
