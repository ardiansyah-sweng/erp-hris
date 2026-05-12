<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Services\EmployeeService;

class EmployeeServiceTest extends TestCase
{
    public function test_show_employee_returns_data()
    {
        $service = new EmployeeService();

        $employees = $service->showEmployee();

        $this->assertNotEmpty($employees);
        $this->assertCount(3, $employees);
    }
}