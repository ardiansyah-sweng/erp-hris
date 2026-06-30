<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payroll;
use App\Services\PayrollService;

class PayrollController extends Controller
{
    protected $payrollService;

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

    public function __construct(PayrollService $payrollService)
    {
        $this->payrollService = $payrollService;
    }

    public function index()
    {
        // 1. Mengambil seluruh data payroll yang sudah diproses oleh Service layer
        $payrolls = $this->payrollService->getAllPayroll();

        // 2. Mengirim data ke view 'payroll.index' menggunakan compact
        return view('payroll.index', compact('payrolls'));
    }

    public function filter(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'nullable|integer',
            'month' => 'nullable|integer|between:1,12',
            'year' => 'nullable|integer|digits:4',
        ]);

        $payrolls = $this->payrollService->filterPayroll(
            $validated['employee_id'] ?? null,
            $validated['month'] ?? null,
            $validated['year'] ?? null
        );
    public function update(Request $request, int $id)
    {
        $validated = $request->validate([
            'employee_id' => 'sometimes|integer|exists:employees,id',
            'month' => 'sometimes|integer|between:1,12',
            'year' => 'sometimes|integer|digits:4',
            'basic_salary' => 'sometimes|numeric|min:0',
            'allowances' => 'sometimes|numeric|min:0',
            'deductions' => 'sometimes|numeric|min:0',
            'status' => 'sometimes|string|in:pending,approved,paid',
        ]);

        $payroll = $this->payrollService->updatePayroll($id, $validated);

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
                'message' => 'Payroll filtered successfully!',
                'data' => $payrolls
                'message' => 'Payroll updated successfully!',
                'data' => $payroll
            ]
        ], 200);
    }

    public function destroy(int $id)
    {
        $payroll = $this->payrollService->destroyPayroll($id);

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
                'message' => 'Payroll deleted successfully!',
                'data' => $payroll
            ]
        ], 200);
    }
}