<?php

namespace App\Service\Client\company;

use App\Models\Company;
use App\Service\Main\CrudService;
// use App\Services\Main\CrudService;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;

class CompanyService extends CrudService
{
    protected function getModelClass(): string
    {
        return Company::class;
    }

    /**
     * إنشاء شركة مع owner
     */
    public function createCompany(array $data, int $ownerId): Company
    {
        return DB::transaction(function () use ($data, $ownerId) {
            $company = $this->create([
                'name'     => $data['name'],
                'owner_id' => $ownerId,
            ]);

            // ربط صاحب الشركة بالـ pivot
            $company->users()->attach($ownerId, [
                'role' => 'owner',
            ]);

            return $company;
        });
    }

    /**
     * تحديث بيانات الشركة
     */
    public function updateCompany(Company $company, array $data): Company
    {

        return $this->update($company, $data);
    }

    /**
     * حذف شركة مع مشاريعها
     */
    public function deleteCompany(Company $company): void
    {
        

        DB::transaction(function () use ($company) {
            // حذف المشاريع أولاً أو soft delete
            $company->projects()->delete();

            // حذف الشركة
            $this->delete($company);
        });
    }

    /**
     * جلب مشاريع الشركة (Builder لمرونة Pagination / Filters)
     */
    public function getProjects(Company $company): Builder
    {
        return $company->projects()->latest();
    }

    /**
     * جلب كل الشركات التي ينتمي لها المستخدم
     */
    public function getUserCompanies(int $userId): Builder
    {
        return $this->getQuery()
            ->whereHas('users', fn($q) => $q->where('user_id', $userId));
    }

 
}
