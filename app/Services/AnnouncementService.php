<?php

namespace App\Services;

use App\Models\Announcement;
use Illuminate\Database\Eloquent\Collection;

class AnnouncementService
{
    public function getAllAnnouncements(): Collection
    {
        return Announcement::latest()->get();
    }

    public function getAnnouncementById(int $id): ?Announcement
    {
        return Announcement::find($id);
    }

    public function createAnnouncement(array $data): Announcement
    {
        return Announcement::create($data);
    }

    public function updateAnnouncement(int $id, array $data): ?Announcement
    {
        $announcement = Announcement::find($id);
        if (!$announcement) {
            return null;
        }
        $announcement->update($data);
        return $announcement;
    }

    public function deleteAnnouncement(int $id): ?Announcement
    {
        $announcement = Announcement::find($id);
        if (!$announcement) {
            return null;
        }
        $announcement->delete();
        return $announcement;
    }
}
