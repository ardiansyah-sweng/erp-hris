<?php

namespace Tests\Feature;

use App\Services\AnnouncementService;
use Tests\TestCase;

class AnnouncementServiceTest extends TestCase
{
    public function test_get_all_announcements()
    {
        $service = new AnnouncementService();

        $announcements = $service->getAllAnnouncements();

        $this->assertIsArray($announcements);
        $this->assertNotEmpty($announcements);
    }

    public function test_get_announcement_by_id()
    {
        $service = new AnnouncementService();

        $announcement = $service->getAnnouncementById(1);

        $this->assertNotNull($announcement);
        $this->assertEquals(1, $announcement['id']);
    }
}