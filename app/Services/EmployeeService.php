<?php

namespace App\Services;

use App\Models\Employee;
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
    }
}