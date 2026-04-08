<?php

namespace Tests\Feature;

use App\Models\JobRole;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class JobroleControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test index route returns successful response
     */
    public function test_index_returns_successful_response(): void
    {
        $response = $this->get('/job-roles');

        $response->assertStatus(200);
    }

    /**
     * Test index returns JSON response
     */
    public function test_index_returns_json_response(): void
    {
        $response = $this->get('/job-roles');

        $response->assertJson([
            'success' => true,
        ]);
    }

    /**
     * Test index returns job roles data
     */
    public function test_index_returns_job_roles_data(): void
    {
        $jobRole1 = JobRole::create(['role' => 'Manager']);
        $jobRole2 = JobRole::create(['role' => 'Supervisor']);

        $response = $this->get('/job-roles');

        $response->assertStatus(200);
        $response->assertJsonCount(2, 'data');
    }

    /**
     * Test index returns empty data when no job roles exist
     */
    public function test_index_returns_empty_data_when_no_job_roles(): void
    {
        $response = $this->get('/job-roles');

        $response->assertStatus(200);
        $response->assertJsonCount(0, 'data');
    }
}
