<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;
use App\Models\Employee;

class EmployeeTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that the employees table exists after migration.
     */
    public function test_employees_table_exists(): void
    {
        $this->assertTrue(Schema::hasTable('employees'));
    }

    /**
     * Test that the employees table has all required columns.
     */
    public function test_employees_table_has_expected_columns(): void
    {
        $this->assertTrue(Schema::hasColumns('employees', [
            'id',
            'name',
            'email',
            'phone_number',
            'place_of_birth',
            'date_of_birth',
            'address',
            'id_number',
            'age',
            'role_id',
            'created_at',
            'updated_at',
        ]));
    }

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