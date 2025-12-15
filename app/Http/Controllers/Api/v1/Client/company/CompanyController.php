<?php

namespace App\Http\Controllers\Api\v1\Client\company;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Resource\company\CompanyResource;
use App\Service\Client\company\CompanyService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CompanyController extends Controller
{
    use AuthorizesRequests;
    protected CompanyService $companyService;

    public function __construct(CompanyService $companyService)
    {
        $this->companyService = $companyService;
    }

    /**
     * قائمة الشركات للمستخدم الحالي
     */
    public function index(Request $request)
    {

        $userId = $request->user()->id;

        $companies = $this->companyService
            ->getUserCompanies($userId)
            ->get();

        return CompanyResource::collection($companies);
    }

    /**
     * إنشاء شركة جديدة
     */
    public function store(Request $request): JsonResponse
    {



        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $company = $this->companyService->createCompany(
            $request->only('name'),
            $request->user()->id
        );

        return response()->json([
            'success' => true,

        ], 201);
    }

    /**
     * عرض شركة محددة
     */
    public function show($id): JsonResponse
    {
        $this->authorize('view', Company::class);

        $company = $this->companyService->find($id);

        return response()->json([
            'success' => true,

        ]);
    }

    /**
     * تحديث شركة
     */
    public function update(Request $request,  Company $company): JsonResponse
    {

        
        $this->authorize('update', $company);

        $request->validate([
            'name' => 'sometimes|required|string|max:255',
        ]);
        $company = $this->companyService->updateCompany($company, $request->only('name'));

        return response()->json([
            'success' => true,

        ]);
    }

    /**
     * حذف شركة
     */
    public function destroy($id): JsonResponse
    {
        $this->authorize('delete', Company::class);

        $company = $this->companyService->find($id);
        $this->companyService->deleteCompany($company);

        return response()->json([
            'success' => true,

        ]);
    }
}
