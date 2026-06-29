<?php

namespace Tests\Unit;

use App\Models\Employee;
use App\Services\EmployeeService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EmployeeServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_all_employee_returns_all_employees(): void
    {
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

    public function test_search_employee_returns_matching_records(): void
    {
        Employee::create([
            'name' => 'Asep Kurniawan',
            'email' => 'asep.kurniawan@example.com',
            'phone_number' => '081234567890',
            'place_of_birth' => 'Jakarta',
            'date_of_birth' => '1990-01-01',
            'address' => 'Jl. Mawar No. 1',
            'id_number' => '1234567890123456',
            'age' => 33,
            'role_id' => 1,
        ]);

        Employee::create([
            'name' => 'Rina Suryani',
            'email' => 'rina.suryani@example.com',
            'phone_number' => '089876543210',
            'place_of_birth' => 'Bandung',
            'date_of_birth' => '1992-02-02',
            'address' => 'Jl. Melati No. 2',
            'id_number' => '9876543210987654',
            'age' => 31,
            'role_id' => 2,
        ]);

        $service = new EmployeeService();

        $resultsByName = $service->searchEmployee('Asep');
        $this->assertCount(1, $resultsByName);
        $this->assertEquals('Asep Kurniawan', $resultsByName->first()->name);

        $resultsByEmail = $service->searchEmployee('rina.suryani');
        $this->assertCount(1, $resultsByEmail);
        $this->assertEquals('Rina Suryani', $resultsByEmail->first()->name);

        $resultsByIdNumber = $service->searchEmployee('9876543210987654');
        $this->assertCount(1, $resultsByIdNumber);
        $this->assertEquals('Rina Suryani', $resultsByIdNumber->first()->name);
    }

    public function test_destroy_employee_berhasil(): void
    {
        $employee = Employee::create([
            'name' => 'Ghinan Test',
            'email' => 'ghinan@example.com',
            'phone_number' => '1234567890',
            'place_of_birth' => 'Bandung',
            'date_of_birth' => '1990-01-01',
            'address' => 'Jl. Test',
            'id_number' => '1234567890123499',
            'age' => 25,
            'role_id' => 1,
        ]);

        $service = new EmployeeService();
        $result = $service->destroyEmployee($employee->id);

        $this->assertEquals(200, $result['statusCode']);
        $this->assertEquals('Employee deleted successfully!', $result['message']);
        $this->assertEquals($employee->id, $result['data']['id']);
    }

    public function test_update_employee_calculates_age_and_updates_data(): void
    {
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
        $updateData = [
            'name' => 'John Updated',
            'date_of_birth' => '1985-01-15',
        ];

        $updatedEmployee = $service->updateEmployee($employee->id, $updateData);

        $this->assertNotNull($updatedEmployee);
        $this->assertEquals('John Updated', $updatedEmployee->name);
        $this->assertEquals('1985-01-15', $updatedEmployee->date_of_birth->format('Y-m-d'));
        $this->assertEquals(41, $updatedEmployee->age);
    }

    public function test_update_employee_returns_null_for_non_existent_employee(): void
    {
        $service = new EmployeeService();
        $updatedEmployee = $service->updateEmployee(999, ['name' => 'Test']);
        $this->assertNull($updatedEmployee);
    }
}