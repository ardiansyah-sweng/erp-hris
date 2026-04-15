<?php

namespace Tests\Unit;

use App\Models\Employee;
use Tests\TestCase;

class EmployeeFactoryTest extends TestCase
{

    // Test 1: Data tersimpan ke database
    public function test_creates_employee_in_database()
    {
        $employee = Employee::factory()->create();

        $this->assertModelExists($employee);
        $this->assertNotNull($employee->name);
        $this->assertNotNull($employee->email);
        $this->assertDatabaseHas('employees', [
            'email' => $employee->email,
        ]);
    }

    // Test 2: Semua field terisi dengan benar
    public function test_employee_has_required_fields()
    {
        $employee = Employee::factory()->create();

        $this->assertNotNull($employee->name);
        $this->assertNotNull($employee->email);
        $this->assertNotNull($employee->phone_number);
        $this->assertNotNull($employee->place_of_birth);
        $this->assertNotNull($employee->date_of_birth);
        $this->assertNotNull($employee->address);
        $this->assertNotNull($employee->id_number);
        $this->assertNotNull($employee->age);
        $this->assertNotNull($employee->role_id);
    }

    // Test 3: Age harus positif dan reasonable
    public function test_employee_age_is_valid()
    {
        $employee = Employee::factory()->create();

        $this->assertGreaterThanOrEqual(18, $employee->age);
        $this->assertLessThanOrEqual(60, $employee->age);
    }

    // Test 4: Email harus unik
    public function test_employee_email_is_unique()
    {
        $employees = Employee::factory()->count(5)->create();
        $emails = $employees->pluck('email')->toArray();

        $this->assertCount(5, array_unique($emails));
    }

    // Test 5: Buat banyak employee sekaligus
    public function test_can_create_multiple_employees()
    {
        Employee::factory()->count(10)->create();

        $this->assertDatabaseCount('employees', Employee::count());
    }

    // Test 6: Role ID dalam range yang benar (1-5)
    public function test_employee_role_id_is_valid()
    {
        $employee = Employee::factory()->create();

        $this->assertGreaterThanOrEqual(1, $employee->role_id);
        $this->assertLessThanOrEqual(5, $employee->role_id);
    }
}