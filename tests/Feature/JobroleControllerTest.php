<?php

namespace Tests\Feature;

use Tests\TestCase;

class JobroleControllerTest extends TestCase
{
    public function test_store_berhasil_dengan_name()
    {
        $response = $this->postJson('/test-jobrole', [
            'name' => 'Developer'
        ]);

        $response->assertStatus(200)
                 ->assertJson([
                     'message' => 'store() berhasil dipanggil',
                     'data' => ['name' => 'Developer']
                 ]);
    }

    public function test_store_gagal_tanpa_name()
    {
        $response = $this->postJson('/test-jobrole', []);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['name']);
    }
}