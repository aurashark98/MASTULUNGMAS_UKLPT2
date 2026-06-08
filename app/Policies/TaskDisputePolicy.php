<?php

namespace App\Policies;

use App\Models\TaskDispute;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TaskDisputePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, TaskDispute $taskDispute): bool
    {
        return $user->id === $taskDispute->reporter_id 
            || $user->id === $taskDispute->reported_user_id 
            || $user->role === 'admin';
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, TaskDispute $taskDispute): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, TaskDispute $taskDispute): bool
    {
        return $user->role === 'admin';
    }
}
