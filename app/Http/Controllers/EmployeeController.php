<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Services\EmployeeService;
use Exception;
use Illuminate\Support\Facades\DB;

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

    public function getCashiers()
    {
        $cashierIds = DB::table('job_roles')
            ->where('role', 'cashier')
            ->pluck('id');

        $cashiers = Employee::whereIn('role_id', $cashierIds)->get();

        return response()->json([
            'status' => 'success',
            'data'   => $cashiers,
        ]);
    }
    
    public function index()
{
    $employees = collect([
        (object)[
            'id' => 1,
            'name' => 'Budi Setiawan',
            'email' => 'budi@gmail.com',
            'phone_number' => '081234567890',
            'place_of_birth' => 'Jakarta',
            'date_of_birth' => '2000-01-15'
        ],
        (object)[
            'id' => 2,
            'name' => 'Siti Aminah',
            'email' => 'siti@gmail.com',
            'phone_number' => '082345678901',
            'place_of_birth' => 'Bandung',
            'date_of_birth' => '1999-05-20'
        ],
        (object)[
            'id' => 3,
            'name' => 'Andi Saputra',
            'email' => 'andi@gmail.com',
            'phone_number' => '083456789012',
            'place_of_birth' => 'Surabaya',
            'date_of_birth' => '2001-09-10'
        ]
    ]);

    return view('employee.index', compact('employees'));
}
}
