<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Jobrole;
use App\Models\Department;
use App\Models\Level;
use App\Models\Status;

class JobroleSeeder extends Seeder
{
    public function run(): void
    {
        $it    = Department::where('name', 'IT')->first()->id;
        $hrd   = Department::where('name', 'HRD')->first()->id;
        $prod  = Department::where('name', 'Product')->first()->id;

        $mid    = Level::where('name', 'Mid')->first()->id;
        $senior = Level::where('name', 'Senior')->first()->id;
        $mgr    = Level::where('name', 'Manager')->first()->id;

        $active = Status::where('name', 'Active')->first()->id;

        Jobrole::create([
            'role'          => 'Software Engineer',
            'department_id' => $it,
            'level_id'      => $senior,
            'status_id'     => $active,
        ]);

        Jobrole::create([
            'role'          => 'Data Analyst',
            'department_id' => $it,
            'level_id'      => $mid,
            'status_id'     => $active,
        ]);

        Jobrole::create([
            'role'          => 'HR Manager',
            'department_id' => $hrd,
            'level_id'      => $mgr,
            'status_id'     => $active,
        ]);

        Jobrole::create([
            'role'          => 'Quality Assurance',
            'department_id' => $it,
            'level_id'      => $mid,
            'status_id'     => $active,
        ]);

        Jobrole::create([
            'role'          => 'Product Manager',
            'department_id' => $prod,
            'level_id'      => $senior,
            'status_id'     => $active,
        ]);
    }
}
