<?php

namespace Tests\Feature;

use App\Models\Employee;
use App\Models\Payroll;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PayrollTest extends TestCase
{
    use RefreshDatabase; // Menghapus data test secara otomatis setelah selesai

    public function test_payroll_can_be_created_and_calculated()
    {
        // 1. Persiapan: Buat satu data employee dulu
        $employee = Employee::factory()->create();

        // 2. Eksekusi: Buat data payroll
        $payroll = Payroll::create([
            'employee_id'  => $employee->id,
            'month'        => 5,
            'year'         => 2026,
            'basic_salary' => 5000000,
            'allowances'   => 1000000,
            'deductions'   => 500000,
            'net_salary'   => 5500000, // Hasil manual: (5jt + 1jt) - 500rb
            'status'       => 'pending',
        ]);

        // 3. Penegasan (Assertion): Pastikan data ada di database
        $this->assertDatabaseHas('payrolls', [
            'employee_id' => $employee->id,
            'net_salary'  => 5500000
        ]);

        // Pastikan relasi ke employee jalan
        $this->assertEquals($employee->name, $payroll->employee->name);
    }
}