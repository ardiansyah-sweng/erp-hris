<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Payroll;
use App\Models\Employee;

class PayrollSeeder extends Seeder
{
    public function run(): void
    {
        $basicSalaryByRole = [
            'Software Engineer' => 8000000,
            'Data Analyst'      => 7000000,
            'HR Manager'        => 9000000,
            'Quality Assurance' => 6000000,
            'Product Manager'   => 10000000,
        ];

        $employees = Employee::all();

        if ($employees->isEmpty()) {
            $this->command->warn('Tidak ada data employee. Jalankan EmployeeSeeder dulu.');
            return;
        }

        foreach ($employees as $employee) {
            $roleName    = $employee->jobrole->role ?? 'Software Engineer';
            $basicSalary = $basicSalaryByRole[$roleName] ?? 5000000;

            Payroll::factory()->approved()->create([
                'employee_id'  => $employee->id,
                'basic_salary' => $basicSalary,
                'month'        => 1,
                'year'         => 2026,
            ]);

            Payroll::factory()->paid()->create([
                'employee_id'  => $employee->id,
                'basic_salary' => $basicSalary,
                'month'        => 2,
                'year'         => 2026,
            ]);

            Payroll::factory()->pending()->create([
                'employee_id'  => $employee->id,
                'basic_salary' => $basicSalary,
                'month'        => 3,
                'year'         => 2026,
            ]);
        }

        $this->command->info('PayrollSeeder berhasil dijalankan.');
    }
}