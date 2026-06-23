<?php

namespace Tests\Unit;

use App\Models\Payroll;
use App\Services\PayrollService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Tests\TestCase;

class PayrollServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_all_payroll_returns_all_data_from_database(): void
    {
        Payroll::factory()->count(3)->create();

        $service = new PayrollService();
        $result = $service->getAllPayroll();

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertCount(3, $result);
    }

    public function test_update_payroll_recalculates_net_salary(): void
    {
        $payroll = Payroll::factory()->create([
            'basic_salary' => 5000000,
            'allowances' => 1000000,
            'deductions' => 500000,
            'net_salary' => 5500000,
        ]);

        $updatedPayroll = app(PayrollService::class)->updatePayroll(
            $payroll->id,
            [
                'allowances' => 1500000,
                'deductions' => 250000,
            ]
        );

        $this->assertNotNull($updatedPayroll);
        $this->assertEquals(6250000, $updatedPayroll->net_salary);
        $this->assertDatabaseHas('payrolls', [
            'id' => $payroll->id,
            'allowances' => 1500000,
            'deductions' => 250000,
            'net_salary' => 6250000,
        ]);
    }

    public function test_update_payroll_returns_null_when_payroll_does_not_exist(): void
    {
        $result = app(PayrollService::class)->updatePayroll(999, [
            'basic_salary' => 5000000,
        ]);

        $this->assertNull($result);
    }

    public function test_destroy_payroll_deletes_payroll(): void
    {
        $payroll = Payroll::factory()->create();

        $deletedPayroll = app(PayrollService::class)->destroyPayroll($payroll->id);

        $this->assertNotNull($deletedPayroll);
        $this->assertEquals($payroll->id, $deletedPayroll->id);
        $this->assertDatabaseMissing('payrolls', [
            'id' => $payroll->id,
        ]);
    }

    public function test_destroy_payroll_returns_null_when_payroll_does_not_exist(): void
    {
        $result = app(PayrollService::class)->destroyPayroll(999);

        $this->assertNull($result);
    }
}