<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Jobrole;

class JobroleSeeder extends Seeder
{
    public function run(): void
    {
        // Data dummy pertama
        Jobrole::create([
            'name' => 'Backend Developer',
            'description' => 'Bertanggung jawab atas logic server dan database.'
        ]);

        // Data dummy kedua
        Jobrole::create([
            'name' => 'UI/UX Designer',
            'description' => 'Mendesain tampilan aplikasi agar user nyaman.'
        ]);
    }
}