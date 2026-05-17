<?php

namespace App\Policies;

use App\Models\Customer;
use App\Models\User;

class CustomerPolicy
{
    /**
     * Admins and managers see all customers.
     * Sales executives see customers assigned to them.
     * Support agents can view customers (to handle issues) but not create/delete.
     */
    public function viewAny(User $user): bool
    {
        return true; // All roles can access the customer list (scoped by role)
    }

    public function view(User $user, Customer $customer): bool
    {
        if ($user->isAdmin() || $user->isManager()) {
            return true;
        }
        if ($user->isSupportAgent()) {
            return true; // Support agents can view any customer to handle issues
        }
        return $customer->assigned_to === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isManager() || $user->isSalesExecutive();
    }

    public function update(User $user, Customer $customer): bool
    {
        if ($user->isAdmin() || $user->isManager()) {
            return true;
        }
        if ($user->isSupportAgent()) {
            return false; // Support agents cannot edit customer records
        }
        return $user->isSalesExecutive() && $customer->assigned_to === $user->id;
    }

    public function delete(User $user, Customer $customer): bool
    {
        return $user->isAdmin();
    }
}
