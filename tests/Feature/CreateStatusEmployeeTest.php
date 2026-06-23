<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Employee;
use App\Models\Jobrole;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateStatusEmployeeTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 1. TEST: Memastikan filter status 'Active' berfungsi via JSON
     */
    public function test_can_filter_employees_by_active_status()
    {
        $role = Jobrole::factory()->create();

        // Buat Karyawan Active
        Employee::factory()->create([
            'name' => 'Girhantri Active',
            'status' => 'Active',
            'role_id' => $role->id
        ]);

        // Buat Karyawan Inactive
        Employee::factory()->create([
            'name' => 'Ricky Inactive',
            'status' => 'Inactive',
            'role_id' => $role->id
        ]);

        $response = $this->getJson('/employees/status-temp?status=Active');

        $response->assertStatus(200);
        
        // Memastikan data JSON mengandung nama yang Active dan tidak mengandung yang Inactive
        $response->assertJsonFragment(['name' => 'Girhantri Active']);
        $response->assertJsonMissing(['name' => 'Ricky Inactive']);
    }

    /**
     * 2. TEST: Memastikan filter status 'Inactive' berfungsi via JSON
     */
    public function test_can_filter_employees_by_inactive_status()
    {
        $role = Jobrole::factory()->create();

        Employee::factory()->create([
            'name' => 'Girhantri Active',
            'status' => 'Active',
            'role_id' => $role->id
        ]);

        Employee::factory()->create([
            'name' => 'Ricky Inactive',
            'status' => 'Inactive',
            'role_id' => $role->id
        ]);

        $response = $this->getJson('/employees/status-temp?status=Inactive');

        $response->assertStatus(200);
        
        // Memastikan data JSON mengandung nama yang Inactive dan tidak mengandung yang Active
        $response->assertJsonFragment(['name' => 'Ricky Inactive']);
        $response->assertJsonMissing(['name' => 'Girhantri Active']);
    }
}