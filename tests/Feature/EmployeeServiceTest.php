<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Employee;
use App\Services\EmployeeService;

class EmployeeServiceTest extends TestCase
{
    public function test_show_employee_returns_data(): void
{
Employee::create([
    'name' => 'Budi Santoso',
    'email' => 'budi@mail.com',
    'phone_number' => '08123456789',
    'place_of_birth' => 'Yogyakarta',
    'date_of_birth' => '2000-01-01',
    'address' => 'Jl. Malioboro No.1',
    'id_number' => '1234567890',
    'role_id' => 1
]);

        $service = new EmployeeService();

        $employees = $service->showEmployee();

        $this->assertNotEmpty($employees);
        $this->assertCount(1, $employees);
    }
}