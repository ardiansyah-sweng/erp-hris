<?php

namespace App\Services;

use App\Models\Payroll;

class PayrollService
{
    /**
     * Mengambil semua data payroll asli dari database SQL beserta relasi employee.
     */
    public function getAllPayroll()
    {
        return Payroll::with('employee')->get();
    }

    public function updatePayroll(int $id, array $data): ?Payroll
    {
        $payroll = Payroll::find($id);

        if (! $payroll) {
            return null;
        }

        $basicSalary = $data['basic_salary'] ?? $payroll->basic_salary;
        $allowances = $data['allowances'] ?? $payroll->allowances;
        $deductions = $data['deductions'] ?? $payroll->deductions;

        $data['net_salary'] = $basicSalary + $allowances - $deductions;

        $payroll->update($data);

        return $payroll->load('employee');
    }

    public function destroyPayroll(int $id): ?Payroll
    {
        $payroll = Payroll::with('employee')->find($id);

        if (! $payroll) {
            return null;
        }

        $payroll->delete();

        return $payroll;
    }
}