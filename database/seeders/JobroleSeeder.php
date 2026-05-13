<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Jobrole;

class JobroleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Generate 10 data random menggunakan factory
        Jobrole::factory()->count(10)->create();
    }
}