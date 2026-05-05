<?php

namespace App\Services;

use App\Models\Employee;

class EmployeeService
{

    public function showEmployee()
{
    // dummy
    $useDummy = true;

    if ($useDummy) {
        return collect([
            [
                'id' => 1,
                'name' => 'Budi Santoso',
                'email' => 'budi@mail.com',
                'job_role' => 'Cashier'
            ],
            [
                'id' => 2,
                'name' => 'Siti Aminah',
                'email' => 'siti@mail.com',
                'job_role' => 'Manager'
            ],
            [
                'id' => 3,
                'name' => 'Andi Wijaya',
                'email' => 'andi@mail.com',
                'job_role' => 'Admin'
            ]
        ]);
    }

    return Employee::all();
}

}