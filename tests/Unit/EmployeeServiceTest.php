<?php

namespace Tests\Unit;


use Tests\TestCase;
use App\Models\Employee;
use App\Services\EmployeeService;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\Employee;
use App\Services\EmployeeService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EmployeeServiceTest extends TestCase
{
    use RefreshDatabase;


    public function test_update_employee_success()
    {
        $employee = Employee::create([
            'name' => 'Lama',
            'email' => 'lama@gmail.com',
            'phone_number' => '123',
            'place_of_birth' => 'Solo',
            'date_of_birth' => '2000-01-01',
            'address' => 'Jl A',
            'id_number' => '111',
            'age' => 20,
            'role_id' => 1,
        ]);

        $service = new EmployeeService();

        $data = [
            'name' => 'Baru',
            'email' => 'baru@gmail.com'
        ];

        $updated = $service->updateEmployee($employee->id, $data);

        $this->assertEquals('Baru', $updated->name);
        $this->assertEquals('baru@gmail.com', $updated->email);

    public function test_get_all_employee_returns_all_employees(): void
    {
        // Create some test employees
        Employee::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone_number' => '1234567890',
            'place_of_birth' => 'Jakarta',
            'date_of_birth' => '1990-01-01',
            'address' => 'Jl. Example',
            'id_number' => '1234567890123456',
            'age' => 30,
            'role_id' => 1,
        ]);

        Employee::create([
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'phone_number' => '0987654321',
            'place_of_birth' => 'Bandung',
            'date_of_birth' => '1992-02-02',
            'address' => 'Jl. Another',
            'id_number' => '6543210987654321',
            'age' => 28,
            'role_id' => 2,
        ]);

        $service = new EmployeeService();
        $employees = $service->getAllEmployee();

        $this->assertCount(2, $employees);
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Collection::class, $employees);
    }
}
