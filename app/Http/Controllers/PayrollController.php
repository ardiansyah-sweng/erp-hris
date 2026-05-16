<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payroll;

class PayrollController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'month' => 'required|integer',
            'year' => 'required|integer',
            'basic_salary' => 'required|numeric',
            'allowances' => 'nullable|numeric',
            'deductions' => 'nullable|numeric',
            'status' => 'nullable|string',
        ]);

        $validated['allowances'] = $validated['allowances'] ?? 0;
        $validated['deductions'] = $validated['deductions'] ?? 0;

        $validated['net_salary'] =
            $validated['basic_salary']
            + $validated['allowances']
            - $validated['deductions'];

        $payroll = Payroll::create($validated);

        return response()->json([
            'payload' => [
                'statusCode' => 201,
                'message' => 'Payroll created successfully!',
                'data' => $payroll
            ]
        ], 201);
    }

    public function show($id)
    {
        $payroll = Payroll::with('employee')->find($id);

        if (!$payroll) {
            return response()->json([
                'payload' => [
                    'statusCode' => 404,
                    'message' => 'Payroll not found',
                    'data' => null
                ]
            ], 404);
        }

        return response()->json([
            'payload' => [
                'statusCode' => 200,
                'message' => 'Payroll retrieved successfully!',
                'data' => $payroll
            ]
        ], 200);
    }
}