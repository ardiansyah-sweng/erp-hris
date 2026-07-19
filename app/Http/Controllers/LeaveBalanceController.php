<?php

namespace App\Http\Controllers;

use App\Models\Employee;

class LeaveBalanceController extends Controller
{
    public function check($employeeCode)
    {
        $employee = Employee::where('employee_code', $employeeCode)->first();

        if (!$employee) {
            return response()->json([
                'found' => false,
                'remaining_leave' => 0,
                'employee_name' => null,
            ]);
        }

        return response()->json([
            'found' => true,
            'remaining_leave' => $employee->remaining_leave,
            'employee_name' => $employee->name,
        ]);
    }
}
