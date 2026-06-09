<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Employee;
use App\Models\Payroll;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PayrollControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_store_payroll_success()
    {
        $employee = Employee::create([
            'name' => 'Ilham',
            'email' => 'ilham@gmail.com',
            'phone_number' => '08123456789',
            'place_of_birth' => 'Jakarta',
            'date_of_birth' => '2000-01-01',
            'address' => 'Jl. Testing',
            'id_number' => '123456789',
            'age' => 25,
            'role_id' => 1,
        ]);

        $response = $this->postJson('/payroll', [
            'employee_id' => $employee->id,
            'month' => 5,
            'year' => 2026,
            'basic_salary' => 5000000,
            'allowances' => 1000000,
            'deductions' => 500000,
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('payrolls', [
            'employee_id' => $employee->id,
            'month' => 5,
            'year' => 2026,
        ]);
    }

    public function test_show_payroll_success()
    {
        $employee = Employee::create([
            'name' => 'Ilham',
            'email' => 'ilhamshow@gmail.com',
            'phone_number' => '08123456789',
            'place_of_birth' => 'Bandung',
            'date_of_birth' => '2000-01-01',
            'address' => 'Jl. Show',
            'id_number' => '987654321',
            'age' => 25,
            'role_id' => 1,
        ]);

        $payroll = Payroll::create([
            'employee_id' => $employee->id,
            'month' => 5,
            'year' => 2026,
            'basic_salary' => 5000000,
            'allowances' => 1000000,
            'deductions' => 500000,
            'net_salary' => 5500000,
            'status' => 'pending',
        ]);

        $response = $this->getJson('/payroll/' . $payroll->id);

        $response->assertStatus(200);

        $response->assertJson([
            'payload' => [
                'statusCode' => 200,
                'message' => 'Payroll retrieved successfully!',
            ]
        ]);
    }
}