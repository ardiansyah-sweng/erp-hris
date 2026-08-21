<?php

namespace Database\Seeders;

use App\Models\Recruitment;
use Illuminate\Database\Seeder;

class RecruitmentSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'name'          => 'Budi Setiawan',
                'email'         => 'budi.setiawan@mail.com',
                'phone_number'  => '081234567801',
                'role_id'       => 2,
                'apply_date'    => '2026-08-01',
                'cv'            => null,
                'status'        => 'Screening',
                'notes'         => 'Lulus seleksi berkas, menunggu jadwal screening.',
            ],
            [
                'name'          => 'Siti Rahma',
                'email'         => 'siti.rahma@mail.com',
                'phone_number'  => '081234567802',
                'role_id'       => 1,
                'apply_date'    => '2026-08-02',
                'cv'            => null,
                'status'        => 'Screening',
                'notes'         => 'Berkas diterima, sedang proses verifikasi.',
            ],
            [
                'name'          => 'Andi Wijaya',
                'email'         => 'andi.wijaya@mail.com',
                'phone_number'  => '081234567803',
                'role_id'       => 3,
                'apply_date'    => '2026-07-28',
                'cv'            => null,
                'status'        => 'Interview',
                'notes'         => 'Jadwal interview HRD tanggal 12 Agustus 2026.',
            ],
            [
                'name'          => 'Dewi Lestari',
                'email'         => 'dewi.lestari@mail.com',
                'phone_number'  => '081234567804',
                'role_id'       => 4,
                'apply_date'    => '2026-07-25',
                'cv'            => null,
                'status'        => 'Interview',
                'notes'         => 'Interview teknis selesai, menunggu hasil.',
            ],
            [
                'name'          => 'Rijal Pratama',
                'email'         => 'rizki.pratama@mail.com',
                'phone_number'  => '081234567805',
                'role_id'       => 5,
                'apply_date'    => '2026-07-20',
                'cv'            => null,
                'status'        => 'Accepted',
                'notes'         => 'Diterima, menunggu proses on-boarding.',
            ],
            [
                'name'          => 'Sari Melati',
                'email'         => 'maya.sari@mail.com',
                'phone_number'  => '081234567806',
                'role_id'       => 2,
                'apply_date'    => '2026-07-18',
                'cv'            => null,
                'status'        => 'Rejected',
                'notes'         => 'Tidak memenuhi kualifikasi pada tahap screening.',
            ],
        ];

        foreach ($data as $recruit) {
            Recruitment::firstOrCreate(['email' => $recruit['email']], $recruit);
        }
    }
}
