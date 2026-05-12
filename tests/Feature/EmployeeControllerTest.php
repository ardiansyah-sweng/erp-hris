<?php

namespace Tests\Feature;

use App\Models\Employee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EmployeeControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_store_employee_successfully()
    {
        $data = [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'phone_number' => '08123456789',
            'place_of_birth' => 'Jakarta',
            'date_of_birth' => '1995-05-20',
            'address' => 'Jl. Sudirman No. 1',
            'id_number' => '3201234567890001',
            'role_id' => 1,
        ];

        $response = $this->postJson('/employees', $data);

        $response->assertStatus(201)
            ->assertJson([
                'payload' => [
                    'statusCode' => 201,
                    'message' => 'Employee created successfully!',
                ]
            ]);

        $this->assertDatabaseHas('employees', [
            'email' => 'john.doe@example.com',
            'id_number' => '3201234567890001'
        ]);
    }


    public function test_store_employee_validation_fails()
    {
        // Mengirim data kosong untuk memicu kegagalan validasi
        $response = $this->postJson('/employees', []);

        $response->assertStatus(422); // Unprocessable Entity
    }


    public function test_show_employee_successfully()
    {
        $employee = Employee::factory()->create();

        $response = $this->getJson("/employees/{$employee->id}");

        $response->assertStatus(200)
            ->assertJsonPath('payload.data.id', $employee->id)
            ->assertJsonPath('payload.message', 'Employee retrieved successfully!');
    }

    public function test_show_employee_not_found()
    {
        $response = $this->getJson('/employees/9999');

        $response->assertStatus(404);
    }

    public function test_get_cashiers_returns_json()
    {
        $response = $this->get('/cashiers');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status',
            'data',
        ]);
        $response->assertJson([
            'status' => 'success',
        ]);
    }
}