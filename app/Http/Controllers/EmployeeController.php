<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Employee;
use Carbon\Carbon;

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
        $employee = Employee::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:employees,email,' . $id,
            'phone_number' => 'required|string',
            'place_of_birth' => 'required|string',
            'date_of_birth' => 'required|date',
            'address' => 'required|string',
            'id_number' => 'required|string|unique:employees,id_number,' . $id,
            'role_id' => 'required|integer',
        ]);

        $validated['age'] = Carbon::parse($validated['date_of_birth'])->age;

        $employee->update($validated);

        return response()->json([
            'payload' => [
                'statusCode' => 200,
                'message' => 'Employee updated successfully!',
                'data' => $employee->fresh()
            ]
        ], 200);
    }
}