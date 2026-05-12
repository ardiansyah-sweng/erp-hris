<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Services\EmployeeService;
use App\Models\Employee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Jobrole;
use Carbon\Carbon;

class CreateEmployeeTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_employee_success()
    {

        Carbon::setTestNow(Carbon::parse('2026-01-01'));

        $role = Jobrole::factory()->create();

        $service = new EmployeeService();

        $data = [
            'name' => 'Fikri',
            'email' => 'fikri@test.com',
            'phone_number' => '08123456789',
            'place_of_birth' => 'Yogyakarta',
            'date_of_birth' => '2000-01-01',
            'address' => 'Jl. Malioboro',
            'id_number' => '1234567890',
            'role_id' => $role->id,
        ];

        $employee = $service->createEmployee($data);

        // ✅ cek database
        $this->assertDatabaseHas('employees', [
            'email' => 'fikri@test.com',
        ]);

        // ✅ cek object
        $this->assertInstanceOf(Employee::class, $employee);

        // ✅ cek umur (SEKARANG PASTI SAMA)
        $expectedAge = Carbon::parse('2000-01-01')->diffInYears(Carbon::now());

        $this->assertEquals($expectedAge, $employee->age);
    }
}