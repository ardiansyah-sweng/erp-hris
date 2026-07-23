<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payroll;
use App\Models\Employee;
use App\Services\PayrollService;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf; 

class PayrollController extends Controller
{
    protected $payrollService;

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

        // ==========================================
        // 🌟 INJEKSI LOG: UNTUK AKSI CREATE
        // ==========================================
        DB::table('activity_logs')->insert([
            'user_email'  => auth()->user()->email ?? 'admin@erphris.com',
            'action'      => 'CREATE',
            'module'      => 'Payroll',
            'description' => 'Membuat data payroll baru untuk ID Karyawan: ' . $payroll->employee_id . ' (Net: ' . $validated['net_salary'] . ')',
            'created_at'  => now()
        ]);

        return response()->json([
            'payload' => [
                'statusCode' => 201,
                'message' => 'Payroll created successfully!',
                'data' => $payroll
            ]
        ], 201);
    }

    public function show(Request $request, $id)
    {
        $payroll = Payroll::with('employee.jobrole')->find($id);

        if ($request->expectsJson()) {
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

        if (!$payroll) {
            abort(404);
        }

        return view('payroll.show', compact('payroll'));
    }

    public function edit($id)
    {
        $payroll = Payroll::with('employee')->findOrFail($id);
        $employees = Employee::orderBy('name')->get();

        return view('payroll.edit', compact('payroll', 'employees'));
    }

    public function update(Request $request, $id)
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
            if ($request->expectsJson()) {
                return response()->json([
                    'payload' => [
                        'statusCode' => 404,
                        'message' => 'Payroll not found',
                        'data' => null
                    ]
                ], 404);
            }

            abort(404);
        }

        // ==========================================
        // 🌟 INJEKSI LOG: UNTUK AKSI UPDATE
        // ==========================================
        DB::table('activity_logs')->insert([
            'user_email'  => auth()->user()->email ?? 'admin@erphris.com',
            'action'      => 'UPDATE',
            'module'      => 'Payroll',
            'description' => 'Memperbarui rincian data payroll ID: ' . $id . ' (Status: ' . ($payroll->status ?? 'updated') . ')',
            'created_at'  => now()
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'payload' => [
                    'statusCode' => 200,
                    'message' => 'Payroll updated successfully!',
                    'data' => $payroll
                ]
            ], 200);
        }

        return redirect()
            ->route('payroll.index')
            ->with('success', 'Data penggajian berhasil diperbarui.');
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

        // ==========================================
        // 🌟 INJEKSI LOG: UNTUK AKSI DELETE
        // ==========================================
        DB::table('activity_logs')->insert([
            'user_email'  => auth()->user()->email ?? 'admin@erphris.com',
            'action'      => 'DELETE',
            'module'      => 'Payroll',
            'description' => 'Menghapus permanen data payroll ID: ' . $id . ' dari sistem.',
            'created_at'  => now()
        ]);

        return response()->json([
            'payload' => [
                'statusCode' => 200,
                'message' => 'Payroll deleted successfully!',
                'data' => $payroll
            ]
        ], 200);
    }

    public function export()
    {
        $payrolls = $this->payrollService->getAllPayroll();
        $payrolls->load('employee.jobrole');

        $fileName = 'penggajian_' . now()->format('Y-m-d') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ];

        $columns = ['No', 'Nama Karyawan', 'Jabatan', 'Bulan', 'Tahun',
            'Gaji Pokok', 'Tunjangan', 'Potongan', 'Gaji Bersih', 'Status'];

        $callback = function () use ($payrolls, $columns) {
            $output = fopen('php://output', 'w');

            fwrite($output, "\xEF\xBB\xBF");
            fputcsv($output, $columns);

            foreach ($payrolls as $index => $payroll) {
                fputcsv($output, [
                    $index + 1,
                    $payroll->employee->name ?? '-',
                    $payroll->employee->jobrole->role ?? '-',
                    $payroll->month,
                    $payroll->year,
                    $payroll->basic_salary,
                    $payroll->allowances,
                    $payroll->deductions,
                    $payroll->net_salary,
                    $payroll->status,
                ]);
            }

            fclose($output);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportPdf($id)
    {
        $payroll = Payroll::with('employee.jobrole')->findOrFail($id);

        if (strtolower($payroll->status) !== 'paid') {
            return redirect()
                ->route('payroll.index')
                ->with('error', 'Slip Gaji PDF hanya dapat diakses jika status pembayaran sudah Paid.');
        }

        // Injeksi Activity Log
        DB::table('activity_logs')->insert([
            'user_email'  => auth()->user()->email ?? 'admin@erphris.com',
            'action'      => 'EXPORT_PDF',
            'module'      => 'Payroll',
            'description' => 'Mengunduh Slip Gaji PDF untuk Karyawan: ' . ($payroll->employee->name ?? 'ID '.$payroll->employee_id),
            'created_at'  => now()
        ]);

        $pdf = Pdf::loadView('payroll.pdf', compact('payroll'));
        
        $employeeName = str_replace(' ', '_', preg_replace('/[^A-Za-z0-9\-]/', '', $payroll->employee->name ?? 'Karyawan'));
        $fileName = 'Slip_Gaji_' . $employeeName . '_' . $payroll->month . '_' . $payroll->year . '.pdf';

        return $pdf->stream($fileName);
    }
}