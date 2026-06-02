<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Jobrole;
use App\Services\JobroleService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class JobroleServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_jobrole()
    {
        $service = app(JobroleService::class);

        $jobrole = $service->createJobrole([
            'role' => 'Web Developer'
        ]);

        $this->assertNotNull($jobrole);
        $this->assertEquals('Web Developer', $jobrole->role);

        $this->assertDatabaseHas('job_roles', [
            'role' => 'Web Developer'
        ]);
    }

    public function test_get_all_jobroles()
    {
        Jobrole::create([
            'role' => 'Frontend Developer'
        ]);

        Jobrole::create([
            'role' => 'Backend Developer'
        ]);

        $service = app(JobroleService::class);

        $jobroles = $service->getAllJobrole();

        $this->assertCount(2, $jobroles);
    }

    public function test_show_jobrole()
    {
        $jobrole = Jobrole::create([
            'role' => 'UI/UX Designer'
        ]);

        $service = app(JobroleService::class);

        $result = $service->showJobrole($jobrole->id);

        $this->assertEquals($jobrole->id, $result->id);
        $this->assertEquals('UI/UX Designer', $result->role);
    }

    public function test_update_jobrole()
    {
        $jobrole = Jobrole::create([
            'role' => 'Junior Developer'
        ]);

        $service = app(JobroleService::class);

        $updated = $service->updateJobrole($jobrole->id, [
            'role' => 'Senior Developer'
        ]);

        $this->assertEquals('Senior Developer', $updated->role);

        $this->assertDatabaseHas('job_roles', [
            'id' => $jobrole->id,
            'role' => 'Senior Developer'
        ]);
    }
}