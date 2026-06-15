<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Employee;

class EmployeeSearchTest extends TestCase
{
    use RefreshDatabase;

    public function test_search_employee_by_name_returns_matches()
    {
        Employee::create([
            'name' => 'Alice Wonderland',
            'email' => 'alice@example.com',
            'phone_number' => '0811111111',
            'place_of_birth' => 'Bandung',
            'date_of_birth' => '1990-01-01',
            'address' => 'Street A',
            'id_number' => 'ID12345',
            'role_id' => 1
        ]);

        Employee::create([
            'name' => 'Bob Builder',
            'email' => 'bob@example.com',
            'phone_number' => '0822222222',
            'place_of_birth' => 'Jakarta',
            'date_of_birth' => '1985-05-05',
            'address' => 'Street B',
            'id_number' => 'ID67890',
            'role_id' => 1
        ]);

        $response = $this->getJson('/employees?q=Alice');

        $response->assertStatus(200)
            ->assertJsonPath('payload.data.0.name', 'Alice Wonderland');

        $data = $response->json('payload.data');
        $this->assertCount(1, $data);
    }

    public function test_search_employee_by_name_no_results()
    {
        Employee::factory()->create(['name' => 'Charlie']);

        $response = $this->getJson('/employees?q=NonExistingName');

        $response->assertStatus(200);

        $data = $response->json('payload.data');
        $this->assertEmpty($data);
    }
}
