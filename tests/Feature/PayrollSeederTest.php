<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Payroll;
use App\Models\Employee;

class PayrollSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_payroll_seeder_runs_successfully(): void
    {
        // Jalankan seeder employee dulu karena payroll butuh employee
        $this->artisan('db:seed', ['--class' => 'JobRoleSeeder'])
             ->assertExitCode(0);

        $this->artisan('db:seed', ['--class' => 'EmployeeSeeder'])
             ->assertExitCode(0);

        // Jalankan PayrollSeeder
        $this->artisan('db:seed', ['--class' => 'PayrollSeeder'])
             ->assertExitCode(0);
    }

    public function test_payroll_seeder_creates_three_payrolls_per_employee(): void
    {
        $this->artisan('db:seed', ['--class' => 'JobRoleSeeder']);
        $this->artisan('db:seed', ['--class' => 'EmployeeSeeder']);
        $this->artisan('db:seed', ['--class' => 'PayrollSeeder']);

        $employees = Employee::all();
        $totalPayrolls = $employees->count() * 3;

        $this->assertEquals($totalPayrolls, Payroll::count());
    }

    public function test_payroll_seeder_creates_correct_statuses(): void
    {
        $this->artisan('db:seed', ['--class' => 'JobRoleSeeder']);
        $this->artisan('db:seed', ['--class' => 'EmployeeSeeder']);
        $this->artisan('db:seed', ['--class' => 'PayrollSeeder']);

        $this->assertTrue(
            Payroll::where('status', 'approved')->exists()
        );
        $this->assertTrue(
            Payroll::where('status', 'paid')->exists()
        );
        $this->assertTrue(
            Payroll::where('status', 'pending')->exists()
        );
    }
}