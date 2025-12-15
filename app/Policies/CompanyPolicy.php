<?php
namespace  App\Policies;
use App\Models\Company;
use App\Models\Project;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CompanyPolicy
{
    use HandlesAuthorization;

    /**
     * أي عضو بالشركة يمكنه مشاهدة الشركة
     */
    public function view(User $user, Company $company): bool
    {
        return $company->users()->where('user_id', $user->id)->exists();
    }

    /**
     * أي مستخدم يمكنه إنشاء شركة جديدة
     */
    public function create(User $user): bool
    {
        return true; // أو ضع شروط حسب الحاجة
    }

    /**
     * فقط Owner يمكنه تعديل الشركة
     */
    public function update(User $user, Company $company): bool
    {
        $role = $company->users()
            ->where('user_id', $user->id)
            ->first()?->role;

        return $role === 'owner';
    }

    /**
     * فقط Owner يمكنه حذف الشركة
     */
    public function delete(User $user, Company $company): bool
    {
        $role = $company->users()
            ->where('user_id', $user->id)
            ->first()?->role;

        return $role === 'owner';
    }
}
