<?php

namespace Database\Seeders;

use App\Models\Announcement;
use Illuminate\Database\Seeder;

class AnnouncementSeeder extends Seeder
{
    public function run(): void
    {
        Announcement::create([
            'title'        => 'Libur Nasional',
            'content'      => 'Perusahaan libur pada tanggal 17 Agustus dalam rangka memperingati Hari Kemerdekaan Republik Indonesia.',
            'publish_date' => '2026-08-17',
            'status'       => 'Aktif',
        ]);

        Announcement::create([
            'title'        => 'Maintenance Server',
            'content'      => 'ERP akan maintenance pada hari Sabtu pukul 22.00 WIB sampai selesai. Mohon untuk menyimpan pekerjaan Anda sebelum waktu tersebut.',
            'publish_date' => '2026-08-20',
            'status'       => 'Aktif',
        ]);

        Announcement::create([
            'title'        => 'Pelatihan Karyawan Batch 3',
            'content'      => 'Pendaftaran pelatihan karyawan batch 3 telah dibuka. Silakan hubungi HR untuk informasi lebih lanjut.',
            'publish_date' => '2026-07-01',
            'status'       => 'Draft',
        ]);
    }
}
