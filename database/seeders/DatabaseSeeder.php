<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            DepartmentSeeder::class,
            LevelSeeder::class,
            StatusSeeder::class,
            JobroleSeeder::class,
            EmployeeSeeder::class,
            AdminUserSeeder::class,
            PayrollSeeder::class,
            LeaveRequestSeeder::class,
            AttendanceSeeder::class,
            AnnouncementSeeder::class,
        ]);
    }
}