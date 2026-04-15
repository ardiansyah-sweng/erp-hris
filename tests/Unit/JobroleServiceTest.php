<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Jobrole;
use App\Services\JobroleService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class JobroleServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_all_job_role_returns_all_job_roles()
    {
        Jobrole::create([
    'role' => 'Manager'
]);

Jobrole::create([
    'role' => 'Staff'
]);

        $service = new JobroleService();
        $result = $service->getAllJobRole();

        $this->assertCount(2, $result);
        $this->assertEquals('Manager', $result[0]->role);
$this->assertEquals('Staff', $result[1]->role);
    }
}
