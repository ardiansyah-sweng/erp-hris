<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Jobrole;
use App\Models\Department;
use App\Models\Level;

class JobroleSeeder extends Seeder
{
    public function run(): void
    {
        $dept = Department::pluck('id', 'name');
        $lvl  = Level::pluck('id', 'name');

        $data = [
            ['role' => 'Software Engineer',  'department' => 'IT',              'level' => 'Staff'],
            ['role' => 'Data Analyst',       'department' => 'Data',            'level' => 'Senior'],
            ['role' => 'HR Manager',         'department' => 'Human Resources', 'level' => 'Manager'],
            ['role' => 'Quality Assurance',  'department' => 'IT',              'level' => 'Staff'],
            ['role' => 'Product Manager',    'department' => 'Product',         'level' => 'Manager'],
        ];

        foreach ($data as $item) {
            Jobrole::create([
                'role'          => $item['role'],
                'department_id' => $dept[$item['department']] ?? null,
                'level_id'      => $lvl[$item['level']] ?? null,
                'status'        => 'Active',
            ]);
        }
    }
}