<?php

namespace App\Policies;


namespace App\Policies;

use App\Models\Project;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectPolicy
{
    use HandlesAuthorization;

    /**
     * أي عضو بالشركة يمكنه مشاهدة مشروع
     */
    public function view(User $user, Project $project): bool
    {
        $role = $project->company->users()
            ->where('user_id', $user->id)
            ->first()?->role;

        if (!$role) return false;

        // أصحاب المشاريع أو مدراء الشركة يمكنهم مشاهدة أي مشروع
        if (in_array($role, ['owner', 'manager'])) return true;

        // الموظف يشوف المشاريع اللي هو جزء منها
        return $project->users()->where('user_id', $user->id)->exists();
    }

    /**
     * من يمكنه إنشاء مشروع
     */
    public function create(User $user, $company): bool
    {
        $role = $company->users()
            ->where('user_id', $user->id)
            ->first()?->role;

        return in_array($role, ['owner', 'manager']);
    }

    /**
     * من يمكنه تعديل مشروع
     */
    public function update(User $user, Project $project): bool
    {
        $role = $project->company->users()
            ->where('user_id', $user->id)
            ->first()?->role;

        return in_array($role, ['owner', 'manager']);
    }

    /**
     * من يمكنه حذف مشروع
     */
    public function delete(User $user, Project $project): bool
    {
        $role = $project->company->users()
            ->where('user_id', $user->id)
            ->first()?->role;

        return $role === 'owner'; // فقط Owner يحذف
    }
}
