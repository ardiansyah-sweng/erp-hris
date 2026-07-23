<?php

namespace Database\Seeders;

use App\Models\Training;
use Illuminate\Database\Seeder;

class TrainingSeeder extends Seeder
{
    public function run(): void
    {
        Training::insert([
            [
                'title' => 'Laravel Basic',
                'trainer' => 'Budi Santoso',
                'department_id' => 1,
                'training_date' => '2026-07-30',
                'location' => 'Meeting Room A',
                'status' => 'Scheduled',
                'description' => 'Pelatihan Laravel untuk developer.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Leadership',
                'trainer' => 'Siti Rahma',
                'department_id' => 2,
                'training_date' => '2026-08-05',
                'location' => 'Ruang Seminar',
                'status' => 'Completed',
                'description' => 'Pelatihan kepemimpinan.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Public Speaking',
                'trainer' => 'Andi Wijaya',
                'department_id' => 3,
                'training_date' => '2026-08-10',
                'location' => 'Hall Utama',
                'status' => 'Scheduled',
                'description' => 'Meningkatkan kemampuan presentasi.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}