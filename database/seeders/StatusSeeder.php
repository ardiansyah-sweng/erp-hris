<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Status;

class StatusSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = [
            'Active',
            'Inactive',
            'On Hold',
        ];

        foreach ($statuses as $name) {
            Status::create(['name' => $name]);
        }
    }
}
