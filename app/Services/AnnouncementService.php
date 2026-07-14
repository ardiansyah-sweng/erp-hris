<?php

namespace App\Services;

class AnnouncementService
{
    public function getAllAnnouncements()
    {
        return [
            [
                'id' => 1,
                'title' => 'Libur Nasional',
                'content' => 'Perusahaan libur pada tanggal 17 Agustus.',
                'publish_date' => '2026-08-17',
                'status' => 'Aktif',
            ],
            [
                'id' => 2,
                'title' => 'Maintenance Server',
                'content' => 'ERP akan maintenance pukul 22.00 WIB.',
                'publish_date' => '2026-08-20',
                'status' => 'Aktif',
            ],
        ];
    }

    public function getAnnouncementById($id)
    {
        foreach ($this->getAllAnnouncements() as $announcement) {
            if ($announcement['id'] == $id) {
                return $announcement;
            }
        }

        return null;
    }
}