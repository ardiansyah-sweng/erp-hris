<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Level;

class LevelSeeder extends Seeder
{
    public function run(): void
    {
        $levels = [
            'Junior',
            'Mid',
            'Senior',
            'Manager',
            'Lead',
        ];

        foreach ($levels as $name) {
            Level::create(['name' => $name]);
        }
    }
}
