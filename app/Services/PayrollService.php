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
}