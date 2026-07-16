<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Level;

class LevelSeeder extends Seeder
{
    public function run(): void
    {
        $levels = ['Staff', 'Senior', 'Manager', 'Director', 'Intern'];

        foreach ($levels as $name) {
            Level::create(compact('name'));
        }
    }
}
