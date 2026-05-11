<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use Exception;
use Illuminate\Support\Facades\DB;

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

    public function destroy(Employee $employee)
    {
        try {
            // Melakukan penghapusan (akan menjadi Soft Delete jika model mendukung)
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

        $cashiers = \App\Models\Employee::whereIn('role_id', $cashierIds)->get();

        return response()->json([
            'status' => 'success',
            'data'   => $cashiers,
        ]);
    }
}
