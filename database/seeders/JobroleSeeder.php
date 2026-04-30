<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Jobrole;

/**
 * Class JobroleSeeder
 * Seeder untuk mengisi data awal (dummy) pada tabel job_roles
 */
class JobroleSeeder extends Seeder
{
    /**
     * Menjalankan proses seeder ke database
     * Update: Disesuaikan dengan skema tabel terbaru yang hanya menggunakan kolom 'role'
     */
    public function run(): void
    {
        Jobrole::create([
            'role' => 'Software Engineer'
        ]);

        Jobrole::create([
            'role' => 'Data Analyst'
        ]);

        Jobrole::create([
            'role' => 'HR Manager'
        ]);

        Jobrole::create([
            'role' => 'Quality Assurance'
        ]);

        Jobrole::create([
            'role' => 'Product Manager'
        ]);
    }
}