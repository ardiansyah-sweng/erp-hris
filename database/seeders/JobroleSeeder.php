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
            'role'       => 'Software Engineer',
            'department' => 'IT',
            'level'      => 'Staff',
            'status'     => 'Active',
        ]);

        Jobrole::create([
            'role'       => 'Data Analyst',
            'department' => 'Data',
            'level'      => 'Senior',
            'status'     => 'Active',
        ]);

        Jobrole::create([
            'role'       => 'HR Manager',
            'department' => 'Human Resources',
            'level'      => 'Manager',
            'status'     => 'Active',
        ]);

        Jobrole::create([
            'role'       => 'Quality Assurance',
            'department' => 'IT',
            'level'      => 'Staff',
            'status'     => 'Active',
        ]);

        Jobrole::create([
            'role'       => 'Product Manager',
            'department' => 'Product',
            'level'      => 'Manager',
            'status'     => 'Active',
        ]);
    }
}