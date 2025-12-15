<?php

namespace App\Policies;


namespace App\Policies;

use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaskPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Task $task): bool
    {
        $role = $task->project->company->users()
            ->where('user_id', $user->id)
            ->first()?->role;

        if (!$role) return false;

        if (in_array($role, ['owner', 'manager'])) return true;

        // الموظف يشوف المهام المخصصة له فقط
        return $task->assigned_to == $user->id;
    }

    public function create(User $user, $project): bool
    {
        $role = $project->company->users()
            ->where('user_id', $user->id)
            ->first()?->role;

        return in_array($role, ['owner', 'manager']);
    }

    public function update(User $user, Task $task): bool
    {
        $role = $task->project->company->users()
            ->where('user_id', $user->id)
            ->first()?->role;

        return in_array($role, ['owner', 'manager']);
    }

    public function delete(User $user, Task $task): bool
    {
        $role = $task->project->company->users()
            ->where('user_id', $user->id)
            ->first()?->role;

        return $role === 'owner';
    }
}
