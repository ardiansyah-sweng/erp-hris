<?php
namespace Tests\Unit;
use App\Models\Employee;
use Tests\TestCase;
class EmployeeFactoryTest extends TestCase
{
    public function test_generates_employee()
    {
        $employee = Employee::factory()->make();
        $this->assertNotNull($employee->name);
        $this->assertNotNull($employee->email);
    }
}
