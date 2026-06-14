<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JobRole;

class JobRoleSeeder extends Seeder
{
    public function run(): void
    {
        $jobRoles = [
            'HR Manager',
            'HR Staff',
            'Recruitment Staff',
            'Payroll Staff',
            'Finance Manager',
            'Accountant',
            'IT Support',
            'System Analyst',
            'Software Developer',
            'Project Manager',
            'General Manager',
            'Administrative Staff',
            'Employee Relations Officer',
            'Training and Development Staff',
            'Attendance Administrator',
            'Compensation and Benefit Staff',
            'Performance Management Staff',
            'Legal Officer',
            'Operations Manager',
            'Supervisor',
        ];

        foreach ($jobRoles as $role) {
            JobRole::updateOrCreate(
                ['role' => $role],
                ['role' => $role]
            );
        }
    }
}