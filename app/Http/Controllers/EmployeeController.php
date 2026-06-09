<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Services\EmployeeService;
use Exception;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::with('jobrole')->orderBy('created_at', 'desc')->get();

        return view('employee.index', compact('employees'));
    }

    protected $employeeService;

    public function __construct(EmployeeService $employeeService)
    {
        $this->employeeService = $employeeService;
    }

    public function show(Employee $employee)
    {
        $employee = $this->employeeService->showEmployee($employee->id);

        return view('employee.detail', compact('employee'));
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
}
