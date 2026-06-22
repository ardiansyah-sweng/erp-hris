<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\JobRole;
use Illuminate\Foundation\Testing\RefreshDatabase;

class JobRoleFactoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_job_role_factory_can_create_data(): void
    {
        $jobRole = JobRole::factory()->create();

        $this->assertDatabaseHas('job_roles', [
            'id' => $jobRole->id,
            'role' => $jobRole->role,
        ]);
    }
}