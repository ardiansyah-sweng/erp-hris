<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Services\EmployeeService;

class EmployeeController extends Controller
{
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

    public function update(Request $request, $id)
{
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:employees,email,' . $id,
            'phone_number' => 'required|string',
            'place_of_birth' => 'required|string',
            'date_of_birth' => 'required|date',
            'address' => 'required|string',
            'id_number' => 'required|string',
            'role_id' => 'required|integer',
    ]);

    $employeeService = new EmployeeService();
    $employee = $employeeService->updateEmployee($id, $validated);

    if (!$employee) {
        return response()->json([
            'payload' => [
                'statusCode' => 404,
                'message' => 'Employee not found',
                'data' => null
            ]
        ], 404);
    }

    return response()->json([
        'payload' => [
            'statusCode' => 200,
            'message' => 'Employee updated successfully!',
            'data' => $employee
            ]
        ], 200);
    }
}