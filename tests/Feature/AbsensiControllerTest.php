<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AbsensiControllerTest extends TestCase
{
    public function test_get_absensis_returns_json()
    {
        $response = $this->get('/api/absensis');

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