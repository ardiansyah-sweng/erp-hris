<?php

namespace App\Services;

use App\Models\Employee;
use Exception;

class EmployeeService
{
    public function getAllEmployee()
    {
        return Employee::all();
    }

    // method kamu ditambah di sini
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