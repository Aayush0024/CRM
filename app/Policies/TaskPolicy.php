<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;

class TaskPolicy
{
    /**
     * All authenticated roles can view tasks.
     * Agents see only their own tasks.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Task $task): bool
    {
        if ($user->isAdmin() || $user->isManager()) {
            return true;
        }
        return $task->assigned_to === $user->id || $task->created_by === $user->id;
    }

    public function create(User $user): bool
    {
        return true; // All roles can create tasks
    }

    public function update(User $user, Task $task): bool
    {
        if ($user->isAdmin() || $user->isManager()) {
            return true;
        }
        // Agents can update tasks assigned to them
        return $task->assigned_to === $user->id;
    }

    public function delete(User $user, Task $task): bool
    {
        if ($user->isAdmin() || $user->isManager()) {
            return true;
        }
        return $task->created_by === $user->id;
    }

    public function complete(User $user, Task $task): bool
    {
        return $this->update($user, $task);
    }
}
