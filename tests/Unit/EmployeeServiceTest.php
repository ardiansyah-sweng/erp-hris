<?php

namespace Tests\Unit;

use App\Models\Employee;
use App\Services\EmployeeService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EmployeeServiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the getAllEmployee method returns all employees.
     */
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

    /**
     * Test the updateEmployee method updates employee data and calculates age.
     */
    public function test_update_employee_calculates_age_and_updates_data(): void
    {
        // Create a test employee
        $employee = Employee::create([
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

        $service = new EmployeeService();

        // Update employee with new date_of_birth (should recalculate age)
        $updateData = [
            'name' => 'John Updated',
            'date_of_birth' => '1985-01-15', // Should calculate age as 41 in May 2026
        ];

        $updatedEmployee = $service->updateEmployee($employee->id, $updateData);

        $this->assertNotNull($updatedEmployee);
        $this->assertEquals('John Updated', $updatedEmployee->name);
        $this->assertEquals('1985-01-15', $updatedEmployee->date_of_birth->format('Y-m-d'));
        $this->assertEquals(41, $updatedEmployee->age); // Age should be recalculated
    }

    /**
     * Test the updateEmployee method returns null for non-existent employee.
     */
    public function test_update_employee_returns_null_for_non_existent_employee(): void
    {
        $service = new EmployeeService();

        $updatedEmployee = $service->updateEmployee(999, ['name' => 'Test']);

        $this->assertNull($updatedEmployee);
    }
}