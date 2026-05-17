<?php

namespace App\Policies;

use App\Models\Contact;
use App\Models\User;

class ContactPolicy
{
    /**
     * All roles can view contacts.
     * Support agents can create contacts/notes but not delete.
     * Only admins/managers can delete contacts.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Contact $contact): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true; // All roles can create contacts
    }

    public function update(User $user, Contact $contact): bool
    {
        if ($user->isAdmin() || $user->isManager()) {
            return true;
        }
        return $contact->created_by === $user->id;
    }

    public function delete(User $user, Contact $contact): bool
    {
        return $user->isAdmin() || $user->isManager();
    }
}
