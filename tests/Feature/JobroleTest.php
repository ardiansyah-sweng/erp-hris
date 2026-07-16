<?php

namespace Tests\Feature;

use App\Models\Jobrole;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class JobroleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that the job_roles table exists after migration.
     */
    public function test_job_roles_table_exists(): void
    {
        $this->assertTrue(Schema::hasTable('job_roles'));
    }

    /**
     * Test that the job_roles table has all required columns.
     */
    public function test_job_roles_table_has_expected_columns(): void
    {
        $this->assertTrue(Schema::hasColumns('job_roles', [
            'id',
            'role',
            'created_at',
            'updated_at',
        ]));
    }

    public function test_create_jobrole_successfully(): void
    {
        $payload = [
            'name' => 'Software Engineer',
        ];

        $response = $this->postJson('/test-jobrole', $payload);

        $response->assertStatus(201)
            ->assertJson([
                'message' => 'Data berhasil disimpan',
            ]);

        $this->assertDatabaseHas('job_roles', [
            'role' => 'Software Engineer',
        ]);
    }

    public function test_delete_jobrole_successfully(): void
    {
        $jobrole = Jobrole::create([
            'role' => 'Quality Assurance',
        ]);

        $response = $this->deleteJson("/job-roles/{$jobrole->id}");

        $response->assertStatus(200)
            ->assertJson([
                'payload' => [
                    'statusCode' => 200,
                    'message' => 'Job role deleted successfully!',
                ]
            ]);

        $this->assertDatabaseMissing('job_roles', [
            'id' => $jobrole->id,
        ]);
    }
}