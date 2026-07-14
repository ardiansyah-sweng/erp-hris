<?php

namespace App\Services;

use App\Models\Announcement;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AnnouncementService
{
    public function getAllAnnouncements()
    {
        return Announcement::orderBy('publish_date', 'desc')->get();
    }

    public function getAnnouncementById($id)
    {
        return Announcement::find($id);
    }

    public function createAnnouncement(array $data): Announcement
    {
        DB::beginTransaction();

        try {
            $announcement = Announcement::create([
                'title'        => $data['title'],
                'content'      => $data['content'],
                'publish_date' => $data['publish_date'],
                'status'       => $data['status'],
            ]);

            DB::commit();

            return $announcement;
        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Failed to create announcement: ' . $e->getMessage());

            throw $e;
        }
    }

    public function updateAnnouncement($id, array $data)
    {
        $announcement = Announcement::find($id);

        if (!$announcement) {
            return null;
        }

        DB::beginTransaction();

        try {
            $announcement->update([
                'title'        => $data['title'],
                'content'      => $data['content'],
                'publish_date' => $data['publish_date'],
                'status'       => $data['status'],
            ]);

            DB::commit();

            return $announcement;
        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Failed to update announcement: ' . $e->getMessage());

            throw $e;
        }
    }

    public function destroyAnnouncement($id)
    {
        try {
            $announcement = Announcement::findOrFail($id);
            $announcement->delete();

            return [
                'statusCode' => 200,
                'message' => 'Announcement deleted successfully!',
                'data' => [
                    'id' => $announcement->id,
                    'title' => $announcement->title,
                ],
            ];
        } catch (Exception $e) {
            return [
                'statusCode' => 500,
                'message' => 'Gagal menghapus pengumuman.',
                'error' => $e->getMessage(),
            ];
        }
    }
}