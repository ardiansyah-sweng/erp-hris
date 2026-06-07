<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Payroll;
use App\Models\Employee;

class PayrollSeeder extends Seeder
{
    public function run(): void
    {
        $employees = Employee::all();

        if ($employees->isEmpty()) {
            $this->command->warn('Tidak ada data employee. Jalankan EmployeeSeeder dulu.');
            return;
        }

        foreach ($employees as $employee) {
            Payroll::factory()->approved()->create([
                'employee_id' => $employee->id,
                'month'       => 1,
                'year'        => 2026,
            ]);

            Payroll::factory()->paid()->create([
                'employee_id' => $employee->id,
                'month'       => 2,
                'year'        => 2026,
            ]);

            Payroll::factory()->pending()->create([
                'employee_id' => $employee->id,
                'month'       => 3,
                'year'        => 2026,
            ]);
        }

    }
}