<?php

namespace Tests\Unit;

use App\Models\Employee;
use PHPUnit\Framework\TestCase;

class EmployeeModelTest extends TestCase
{
    public function test_employee_model_maps_to_employees_table(): void
    {
        $employee = new Employee();
        $this->assertSame('employees', $employee->getTable());
    }

    public function test_employee_model_has_expected_fillable_attributes(): void
    {
        $employee = new Employee();
        $expected = [
            'name',
            'email',
            'phone_number',
            'place_of_birth',
            'date_of_birth',
            'address',
            'id_number',
            'age',
            'role_id',
        ];
        $this->assertSame($expected, $employee->getFillable());
    }

    public function test_employee_model_has_date_of_birth_cast(): void
    {
        $employee = new Employee();
        $casts = $employee->getCasts();
        $this->assertArrayHasKey('date_of_birth', $casts);
        $this->assertSame('date', $casts['date_of_birth']);
    }

    public function test_employee_model_has_age_cast(): void
    {
        $employee = new Employee();
        $casts = $employee->getCasts();
        $this->assertArrayHasKey('age', $casts);
        $this->assertSame('integer', $casts['age']);
    }

    public function test_employee_model_has_jobrole_relationship_method(): void
    {
        $reflection = new \ReflectionClass(Employee::class);
        $this->assertTrue($reflection->hasMethod('jobrole'));
        $method = $reflection->getMethod('jobrole');
        $this->assertTrue($method->isPublic());
    }
}

