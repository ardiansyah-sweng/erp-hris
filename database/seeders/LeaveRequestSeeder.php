<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LeaveRequest;

class LeaveRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LeaveRequest::factory()->count(10)->create();
    }
}