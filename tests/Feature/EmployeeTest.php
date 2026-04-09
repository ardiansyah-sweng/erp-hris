<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Employee;

class EmployeeTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_employee_successfully()
    {
        $payload = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'position' => 'Developer',
        ];

        $response = $this->postJson('/employees', $payload);

        $response->assertStatus(201)
                 ->assertJson([
                     'payload' => [
                         'statusCode' => 201,
                         'message' => 'Employee created successfully!',
                     ]
                 ]);

        $this->assertDatabaseHas('employees', [
            'email' => 'john@example.com',
        ]);
    }

    public function test_fail_create_employee_with_invalid_data()
    {
        $payload = [
            'name' => '',
            'email' => 'not-an-email',
            'position' => '',
        ];

        $response = $this->postJson('/employees', $payload);

        $response->assertStatus(422);
    }
}