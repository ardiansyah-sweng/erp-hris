<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JobRoleSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('job_roles')->insertOrIgnore([
            ['id' => 1, 'role' => 'Director'],
            ['id' => 2, 'role' => 'General Manager'],
            ['id' => 3, 'role' => 'Manager'],
            ['id' => 4, 'role' => 'Supervisor'],
            ['id' => 5, 'role' => 'Staff'],
        ]);
    }   
}