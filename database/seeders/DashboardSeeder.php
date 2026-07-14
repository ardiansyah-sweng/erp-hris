<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\JobRole;
use Illuminate\Database\Seeder;

class DashboardSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Job Roles
        $roles = [
            'Software Engineer',
            'Data Analyst',
            'HR Specialist',
            'Finance Officer',
            'QA Engineer',
            'Product Designer',
            'DevOps Engineer',
            'Business Analyst',
            'UI/UX Designer',
            'Marketing Specialist',
        ];

        $roleIds = [];
        foreach ($roles as $roleName) {
            $role = JobRole::firstOrCreate(['role' => $roleName]);
            $roleIds[] = $role->id;
        }

        echo "Role IDs: " . implode(',', $roleIds) . PHP_EOL;

        // 2. Employees dalam jumlah lebih banyak (30 orang) dengan variasi status dan tanggal masuk
        $namaDepan = [
            'Ahmad', 'Siti', 'Rizky', 'Laila', 'Hendra', 'Rina', 'Budi', 'Dewi', 'Fajar', 'Citra',
            'Doni', 'Mega', 'Yusuf', 'Nita', 'Bagas', 'Putri', 'Agus', 'Sri', 'Eko', 'Wulan',
            'Iman', 'Ratna', 'Dedi', 'Fitri', 'Galih', 'Herlina', 'Indra', 'Julia', 'Krisna', 'Lestari',
        ];

        $namaBelakang = [
            'Wijaya', 'Santoso', 'Pratama', 'Nurfitri', 'Anggraini', 'Kusuma', 'Hakim', 'Safitri', 'Wicaksono', 'Setiawan',
            'Rahayu', 'Fauzi', 'Putra', 'Utami', 'Nugroho', 'Lestari', 'Permadi', 'Suryani', 'Hidayat', 'Puspita',
        ];

        $statuses = ['active', 'active', 'active', 'active', 'cuti']; // ~80% active, 20% cuti

        for ($i = 0; $i < 30; $i++) {
            $nama = $namaDepan[$i % count($namaDepan)] . ' ' . $namaBelakang[$i % count($namaBelakang)] . ' ' . ($i + 1);
            $status = $statuses[array_rand($statuses)];
            $createdAt = now()->subDays(rand(0, 400)); // sebar dari hari ini sampai ~13 bulan lalu

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