<?php

namespace Tests\Feature;

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
        'name'           => 'John Doe',
        'email'          => 'john.doe@example.com',
        'phone_number'   => '08123456789',
        'place_of_birth' => 'Jakarta',
        'date_of_birth'  => '1995-01-01',
        'address'        => 'Jl. Merdeka No. 123',
        'id_number'      => '3201234567890001',
        'role_id'        => 1, // Pastikan ini integer sesuai validasi
    ];

    $response = $this->postJson('/employees', $payload);

    $response->assertStatus(201)
             ->assertJson([
                 'payload' => [
                     'statusCode' => 201,
                     'message'    => 'Employee created successfully!',
                 ]
             ]);
    $this->assertDatabaseHas('employees', [
        'email' => 'john.doe@example.com'
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

    public function test_delete_employee_successfully()
    {
        $employee = Employee::create([
            'name'           => 'Budi Santoso',
            'email'          => 'budi.test@example.com',
            'phone_number'   => '08123456789',
            'place_of_birth' => 'Jakarta',
            'date_of_birth'  => '1990-05-20',
            'address'        => 'Jl. Sudirman No. 1',
            'id_number'      => '1234567890123456',
            'role_id'        => 1,
        ]);

    
        $response = $this->deleteJson("/employees/{$employee->id}");

        // dd(Route::getRoutes()); 

        $response->assertStatus(200);

        $this->assertDatabaseMissing('employees', [
            'id' => $employee->id
        ]);
    }
}