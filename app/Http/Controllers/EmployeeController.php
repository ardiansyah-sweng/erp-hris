<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobRole; // Import model JobRole
use App\Models\Employee;

class EmployeeController extends Controller
{
    public function create()
    {
        $jobRoles = JobRole::all(); // Ambil semua data job roles
        return view('employee.create', compact('jobRoles')); // Teruskan data ke view
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
            'role_id' => 'required|exists:job_roles,id', 
        ]);

        // Calculate age automatically based on date_of_birth
        $validated['age'] = \Carbon\Carbon::parse($validated['date_of_birth'])->age;

        $employee = Employee::create($validated);

        return response()->json([
            'payload' => [
                'statusCode' => 201,
                'message' => 'Employee created successfully!',
                'data' => $employee
            ]
        ], 201);
    }
}