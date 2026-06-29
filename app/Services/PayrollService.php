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
        // Mengambil data dari database nyata hasil seeder kamu
        return Payroll::with('employee')->get();
    }

    /**
     * Filter payroll berdasarkan employee_id, month, dan/atau year.
     * 
     * @param int|null $employee_id
     * @param int|null $month
     * @param int|null $year
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function filterPayroll($employee_id = null, $month = null, $year = null)
    {
        $query = Payroll::with('employee');

        if ($employee_id !== null) {
            $query->where('employee_id', $employee_id);
        }

        if ($month !== null) {
            $query->where('month', $month);
        }

        if ($year !== null) {
            $query->where('year', $year);
        }

        return $query->get();
    }
}