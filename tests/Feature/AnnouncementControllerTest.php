<?php

namespace Tests\Feature;

use Tests\TestCase;

class AnnouncementControllerTest extends TestCase
{
    public function test_announcement_page_can_be_accessed()
    {
        $response = $this->get('/announcement');

        $response->assertStatus(200);
    }
}