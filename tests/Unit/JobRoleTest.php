<?php

namespace Tests\Unit;

use App\Models\JobRole;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class JobRoleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test create job role
     */
    public function test_can_create_job_role(): void
    {
        $jobRole = JobRole::create([
            'role' => 'Manager',
        ]);

        $this->assertNotNull($jobRole->id);
        $this->assertEquals('Manager', $jobRole->role);
    }

    /**
     * Test read job role
     */
    public function test_can_read_job_role(): void
    {
        $jobRole = JobRole::create([
            'role' => 'Supervisor',
        ]);

        $foundJobRole = JobRole::find($jobRole->id);

        $this->assertNotNull($foundJobRole);
        $this->assertEquals('Supervisor', $foundJobRole->role);
    }

    /**
     * Test update job role
     */
    public function test_can_update_job_role(): void
    {
        $jobRole = JobRole::create([
            'role' => 'Cashier',
        ]);

        $jobRole->update(['role' => 'Senior Cashier']);

        $this->assertEquals('Senior Cashier', $jobRole->role);
    }

    /**
     * Test delete job role
     */
    public function test_can_delete_job_role(): void
    {
        $jobRole = JobRole::create([
            'role' => 'Staff',
        ]);

        $jobRoleId = $jobRole->id;
        $jobRole->delete();

        $this->assertNull(JobRole::find($jobRoleId));
    }

    /**
     * Test job role attributes
     */
    public function test_job_role_has_correct_attributes(): void
    {
        $jobRole = JobRole::create([
            'role' => 'HR Manager',
        ]);

        $this->assertTrue($jobRole->hasAttribute('id'));
        $this->assertTrue($jobRole->hasAttribute('role'));
        $this->assertTrue($jobRole->hasAttribute('created_at'));
        $this->assertTrue($jobRole->hasAttribute('updated_at'));
    }
}
