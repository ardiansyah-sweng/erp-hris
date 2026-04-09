<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class JobroleServiceTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_update_jobrole_successfully()
    {
        $jobrole = \App\Models\Jobrole::create(['name' => 'Old Name', 'description' => 'Old Desc']);

        $service = new \App\Services\JobroleService();
        $service->updateJobrole($jobrole->id, ['name' => 'New Name']);

        $this->assertDatabaseHas('jobroles', [
            'id' => $jobrole->id,
            'name' => 'New Name'
        ]);
    }
}
