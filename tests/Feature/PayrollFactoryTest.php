<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Payroll;
use App\Models\Employee;

class PayrollFactoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_payroll_factory_creates_valid_data(): void
    {
        $payroll = Payroll::factory()->create();

        $this->assertDatabaseHas('payrolls', [
            'id' => $payroll->id,
        ]);
        $this->assertNotNull($payroll->basic_salary);
        $this->assertNotNull($payroll->net_salary);
        $this->assertNotNull($payroll->employee_id);
    }

    public function test_payroll_factory_pending_state(): void
    {
        $payroll = Payroll::factory()->pending()->create();

        $this->assertEquals('pending', $payroll->status);
    }

    public function test_payroll_factory_approved_state(): void
    {
        $payroll = Payroll::factory()->approved()->create();

        $this->assertEquals('approved', $payroll->status);
    }

    public function test_payroll_factory_paid_state(): void
    {
        $payroll = Payroll::factory()->paid()->create();

        $this->assertEquals('paid', $payroll->status);
    }

    public function test_payroll_factory_net_salary_is_calculated_correctly(): void
    {
        $employee = Employee::factory()->create();

        $payroll = Payroll::factory()->create([
            'employee_id'  => $employee->id,
            'basic_salary' => 5000000,
            'allowances'   => 1000000,
            'deductions'   => 500000,
            'net_salary'   => 5500000,
        ]);

        $this->assertEquals(5500000, $payroll->net_salary);
    }

    public function test_payroll_factory_belongs_to_employee(): void
    {
        $employee = Employee::factory()->create();

        $payroll = Payroll::factory()->create([
            'employee_id' => $employee->id,
        ]);

        $this->assertEquals($employee->id, $payroll->employee_id);
        $this->assertEquals($employee->name, $payroll->employee->name);
    }
}