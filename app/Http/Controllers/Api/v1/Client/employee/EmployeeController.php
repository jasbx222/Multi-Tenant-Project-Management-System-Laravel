<?php

namespace App\Http\Controllers\Api\v1\Client\employee;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Resource\employee\EmployeeResource;
use App\Service\Client\employee\EmployeeService;
use Illuminate\Http\Request;

/**
 * Controller مسؤول عن إدارة الموظفين (Employees)
 * عبر API (عرض، إضافة، تعديل، حذف)
 */
class EmployeeController extends Controller
{
    /**
     * Service layer الخاص بالموظفين
     *
     * @var EmployeeService
     */
    private $employeeService;

    /**
     * Inject EmployeeService
     */
    public function __construct(EmployeeService $employeeService)
    {
        $this->employeeService = $employeeService;
    }

    /**
     * عرض جميع الموظفين
     *
     * GET /employees
     */
    public function index(Request $request)
    {
        // جلب قائمة الموظفين من الـ Service
        return EmployeeResource::collection($this->employeeService->getEmployee());
    }

    /**
     * إنشاء موظف جديد
     *
     * POST /employees
     */
    public function store(UserRequest $request)
    {
        // التحقق من البيانات عبر UserRequest
        // ثم إرسال البيانات المفلترة إلى الـ Service
        return $this->employeeService->store($request->validated());
    }

    /**
     * تحديث بيانات موظف
     *
     * PUT /employees/{employee}
     */
    public function update(UpdateUserRequest $request, User $employee)
    {
        // تحديث الموظف المحدد باستخدام Route Model Binding
        return $this->employeeService->updateEmployee(
            $request->validated(),
            $employee
        );
    }

    /**
     * عرض بيانات موظف محدد
     *
     * GET /employees/{employee}
     */
    public function show(User $employee)
    {
        // إرجاع بيانات الموظف
        return new EmployeeResource($this->employeeService->show($employee));
    }

    /**
     * حذف موظف
     *
     * DELETE /employees/{employee}
     */
    public function destroy(User $employee)
    {
        // حذف الموظف من النظام
        return $this->employeeService->delete($employee);
    }
}
