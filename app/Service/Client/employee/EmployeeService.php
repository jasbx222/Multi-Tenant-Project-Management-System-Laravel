<?php

namespace App\Service\Client\employee;
use App\Models\User;
use App\Service\Main\CrudService;


class EmployeeService extends CrudService
{
    protected function getModelClass(): string
    {
        return User::class;
    }

public function getEmployee()
{
    return $this->getQuery()->paginate(10)
        ;
}




    /**
     * إنشاء شركة مع owner
     */
    public function store(array $data)
    {

        $employee = $this->create($data);
        return $employee;
    }


    public function show($employee)
    {
        return $employee;
    }


    public function updateEmployee(array $data,  $employee)
    {
        return $this->update($employee, $data);
    }


    public function deleteEmployee($employee)
    {

        return $this->delete($employee);
        return response()->noContent();
    }
}
