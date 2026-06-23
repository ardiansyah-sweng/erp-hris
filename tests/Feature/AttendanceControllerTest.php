<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AttendanceControllerTest extends TestCase
{
    public function test_get_attendances_returns_json()
    {
        $response = $this->get('/api/attendances');

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