<?php

namespace App\Services;

use App\Models\Employee;
<<<<<<< HEAD
use Carbon\Carbon;
class EmployeeService
{
    public function updateEmployee($id, $data)
    {
        $employee = Employee::find($id);

        if (!$employee) {
            return null;
        }

        if (isset($data['date_of_birth'])) {
            $data['age'] = Carbon::parse($data['date_of_birth'])->age;
    }

        $employee->update($data);

        return $employee;
=======

class EmployeeService
{
    public function getAllEmployee()
    {
        return Employee::all();
>>>>>>> 52be0b1d4566c3d56303d3e5e4f4d6d236f065c2
    }
}