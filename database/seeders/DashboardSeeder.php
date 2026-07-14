<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Jobrole;
use Illuminate\Database\Seeder;

class DashboardSeeder extends Seeder
{
    public function run(): void
    {
        if (Jobrole::count() === 0) {
            $this->call(JobroleSeeder::class);
        }

        $roleIds = Jobrole::pluck('id')->toArray();

        if (empty($roleIds)) {
            echo "Tidak ada job role tersedia, seeder dihentikan." . PHP_EOL;
            return;
        }

        echo "Role IDs dipakai: " . implode(',', $roleIds) . PHP_EOL;

        $namaDepan = [
            'Ahmad', 'Siti', 'Rizky', 'Laila', 'Hendra', 'Rina', 'Budi', 'Dewi', 'Fajar', 'Citra',
            'Doni', 'Mega', 'Yusuf', 'Nita', 'Bagas', 'Putri', 'Agus', 'Sri', 'Eko', 'Wulan',
            'Iman', 'Ratna', 'Dedi', 'Fitri', 'Galih', 'Herlina', 'Indra', 'Julia', 'Krisna', 'Lestari',
        ];

        $namaBelakang = [
            'Wijaya', 'Santoso', 'Pratama', 'Nurfitri', 'Anggraini', 'Kusuma', 'Hakim', 'Safitri', 'Wicaksono', 'Setiawan',
            'Rahayu', 'Fauzi', 'Putra', 'Utami', 'Nugroho', 'Lestari', 'Permadi', 'Suryani', 'Hidayat', 'Puspita',
        ];

        $statuses = ['active', 'active', 'active', 'active', 'cuti'];

        for ($i = 0; $i < 30; $i++) {
            $nama = $namaDepan[$i % count($namaDepan)] . ' ' . $namaBelakang[$i % count($namaBelakang)] . ' ' . ($i + 1);
            $status = $statuses[array_rand($statuses)];
            $createdAt = now()->subDays(rand(0, 400));

            try {
                Employee::create([
                    'name'           => $nama,
                    'email'          => 'karyawan' . uniqid() . '@example.com',
                    'phone_number'   => '08' . rand(1000000000, 1999999999),
                    'place_of_birth' => 'Yogyakarta',
                    'date_of_birth'  => now()->subYears(rand(22, 40))->format('Y-m-d'),
                    'address'        => 'Jl. Contoh No. ' . ($i + 1) . ', Yogyakarta',
                    'id_number'      => (string) rand(1000000000000000, 9999999999999999),
                    'age'            => rand(22, 40),
                    'role_id'        => $roleIds[array_rand($roleIds)],
                    'status'         => $status,
                    'created_at'     => $createdAt,
                    'updated_at'     => $createdAt,
                ]);
                echo "OK: {$nama}" . PHP_EOL;
            } catch (\Throwable $e) {
                echo "GAGAL: {$nama} - " . $e->getMessage() . PHP_EOL;
            }
        }
    }
}