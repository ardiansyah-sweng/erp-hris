<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $departments = [
            'IT',
            'HRD',
            'Product',
            'Finance',
            'Marketing',
        ];

        foreach ($departments as $name) {
            Department::create(['name' => $name]);
        }
    }
}
