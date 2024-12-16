<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TaskPolicy
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
    public function view(User $user, Task $task): bool
    {
        return $this->currentUserIsAuthorOrSuperuser($user, $task);
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
    public function update(User $user, Task $task): bool
    {
        return $this->currentUserIsAuthorOrSuperuser($user, $task);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Task $task): bool
    {
        return $this->currentUserIsAuthorOrSuperuser($user, $task);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Task $task): bool
    {
        return $this->currentUserIsAuthorOrSuperuser($user, $task);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Task $task): bool
    {
        return $this->currentUserIsSuperuser($user);
    }

    private function currentUserIsAuthorOrSuperuser(User $user, Task $task): bool
    {
        return $task->author_id === $user->id || $user->is_superuser;
    }

    private function currentUserIsSuperuser(User $user): bool
    {
        return $user->is_superuser;
    }
}
