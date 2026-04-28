<?php

namespace App\Services;

use App\Models\Employee;

class EmployeeService
{
    public function getAllEmployee()
    {
        return Employee::all();
    }
}