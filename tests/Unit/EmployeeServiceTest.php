<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Employee;
use App\Services\EmployeeService;
use Illuminate\Foundation\Testing\RefreshDatabase;

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
    }
}