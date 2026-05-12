<?php

namespace App\Services;

use App\Models\Employee;
use Exception;
use Carbon\Carbon;

class EmployeeService
{
    public function updateEmployee($id, $data)
    {
        $employee = Employee::find($id);

        if (!$employee) {
            return null;
        }

        if (isset($data['date_of_birth'])) {
        $data['age'] = Carbon::parse($data['date_of_birth'])->age;
        }

        $employee->update($data);

        return $employee;
    }
    
    public function getAllEmployee()
    {
        return Employee::all();
    }
    
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

    public function destroyEmployee($id)
    {
        try {
            $employee = Employee::findOrFail($id);
            $employee->delete();

            return [
                'statusCode' => 200,
                'message' => 'Employee deleted successfully!',
                'data' => [
                    'id' => $employee->id,
                    'name' => $employee->name
                ]
            ];
        } catch (Exception $e) {
            return [
                'statusCode' => 500,
                'message' => 'Gagal menghapus data karyawan.',
                'error' => $e->getMessage()
            ];
        }
    }
}

