<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobRole; // Import model JobRole
use App\Models\Employee;
use App\Services\EmployeeService;
use Exception;

class EmployeeController extends Controller
{
    protected $employeeService;

    public function __construct(EmployeeService $employeeService)
    {
        $this->employeeService = $employeeService;
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:employees,email',
            'phone_number' => 'required|string',
            'place_of_birth' => 'required|string',
            'date_of_birth' => 'required|date',
            'address' => 'required|string',
            'id_number' => 'required|string',
            'role_id' => 'required|integer',
        ]);

        $employee = Employee::create($validated);

        return response()->json([
            'payload' => [
                'statusCode' => 201,
                'message' => 'Employee created successfully!',
                'data' => $employee
            ]
        ], 201);
    }

    public function destroy(Employee $employee)
    {
        try {
            $employee->delete();

            return response()->json([
                'payload' => [
                    'statusCode' => 200,
                    'message' => 'Employee deleted successfully!',
                    'data' => [
                        'id' => $employee->id,
                        'name' => $employee->name
                    ]
                ]
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'payload' => [
                    'statusCode' => 500,
                    'message' => 'Gagal menghapus data karyawan.',
                    'error' => $e->getMessage()
                ]
            ], 500);
        }
    }

    public function show(Employee $employee)
    {
        return response()->json([
            'payload' => [
                'statusCode' => 200,
                'message' => 'Employee retrieved successfully!',
                'data' => $employee
            ]
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name'           => 'required|string',
            'email'          => 'required|email|unique:employees,email,' . $id,
            'phone_number'   => 'required|string',
            'place_of_birth' => 'required|string',
            'date_of_birth'  => 'required|date',
            'address'        => 'required|string',
            'id_number'      => 'required|string',
            'role_id'        => 'required|integer',
        ]);

        $employee = $this->employeeService->updateEmployee($id, $validated);

        if (!$employee) {
            return response()->json([
                'payload' => [
                    'statusCode' => 404,
                    'message'    => 'Employee not found',
                    'data'       => null
                ]
            ], 404);
        }

        return response()->json([
            'payload' => [
                'statusCode' => 200,
                'message'    => 'Employee updated successfully!',
                'data'       => $employee
            ]
        ], 200);
    }
}