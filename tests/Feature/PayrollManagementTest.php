<?php

namespace Tests\Feature;

use App\Models\Payroll;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PayrollManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_update_payroll_successfully(): void
    {
        $payroll = Payroll::factory()->create([
            'basic_salary' => 5000000,
            'allowances' => 1000000,
            'deductions' => 500000,
            'net_salary' => 5500000,
            'status' => 'pending',
        ]);

        $response = $this->putJson("/payroll/{$payroll->id}", [
            'basic_salary' => 6000000,
            'allowances' => 750000,
            'deductions' => 250000,
            'status' => 'approved',
        ]);

        $response
            ->assertOk()
            ->assertJsonPath('payload.statusCode', 200)
            ->assertJsonPath('payload.message', 'Payroll updated successfully!')
            ->assertJsonPath('payload.data.net_salary', 6500000)
            ->assertJsonPath('payload.data.status', 'approved');

        $this->assertDatabaseHas('payrolls', [
            'id' => $payroll->id,
            'basic_salary' => 6000000,
            'allowances' => 750000,
            'deductions' => 250000,
            'net_salary' => 6500000,
            'status' => 'approved',
        ]);
    }

    public function test_update_payroll_returns_not_found(): void
    {
        $response = $this->putJson('/payroll/999', [
            'allowances' => 1000000,
        ]);

        $response
            ->assertNotFound()
            ->assertJsonPath('payload.message', 'Payroll not found');
    }

    public function test_update_payroll_validates_request(): void
    {
        $payroll = Payroll::factory()->create();

        $response = $this->putJson("/payroll/{$payroll->id}", [
            'month' => 13,
            'basic_salary' => -1,
            'status' => 'unknown',
        ]);

        $response
            ->assertUnprocessable()
            ->assertJsonValidationErrors([
                'month',
                'basic_salary',
                'status',
            ]);
    }

    public function test_destroy_payroll_successfully(): void
    {
        $payroll = Payroll::factory()->create();

        $response = $this->deleteJson("/payroll/{$payroll->id}");

        $response
            ->assertOk()
            ->assertJsonPath('payload.statusCode', 200)
            ->assertJsonPath('payload.message', 'Payroll deleted successfully!')
            ->assertJsonPath('payload.data.id', $payroll->id);

        $this->assertDatabaseMissing('payrolls', [
            'id' => $payroll->id,
        ]);
    }

    public function test_destroy_payroll_returns_not_found(): void
    {
        $response = $this->deleteJson('/payroll/999');

        $response
            ->assertNotFound()
            ->assertJsonPath('payload.message', 'Payroll not found');
    }
}
