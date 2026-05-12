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

    public function createEmployee(array $data): Employee
    {
        DB::beginTransaction();

        try {
            $dateOfBirth = Carbon::parse($data['date_of_birth']);
            $age = $dateOfBirth->diffInYears(Carbon::now());

            $employee = Employee::create([
                'name'           => $data['name'],
                'email'          => $data['email'],
                'phone_number'   => $data['phone_number'],
                'place_of_birth' => $data['place_of_birth'],
                'date_of_birth'  => $data['date_of_birth'],
                'address'        => $data['address'],
                'id_number'      => $data['id_number'],
                'age'            => $age,
                'role_id'        => $data['role_id'],
            ]);

            DB::commit();

            return $employee;

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Failed to create employee: ' . $e->getMessage());

            throw $e;
        }
    }
}
