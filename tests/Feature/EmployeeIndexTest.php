<?php

namespace Tests\Feature;

use App\Models\Employee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EmployeeIndexTest extends TestCase
{
    use RefreshDatabase;

    public function test_employee_index_page_can_be_displayed(): void
    {
        Employee::factory()->count(5)->create();

        $response = $this->get('/employees');

        $response->assertStatus(200);
        $response->assertViewIs('employee.index');
        $response->assertViewHas('employees');
    }
}