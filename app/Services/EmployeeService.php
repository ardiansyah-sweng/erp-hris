<?php

namespace App\Services;

use App\Models\Employee;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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

