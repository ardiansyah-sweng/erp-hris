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

    public function show(Request $request, $id)
    {
        $payroll = Payroll::with('employee.jobrole')->find($id);

        // Permintaan API (mis. getJson) tetap menerima respons JSON seperti semula
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

        // Permintaan dari browser menampilkan halaman detail slip gaji
        if (!$payroll) {
            abort(404);
        }

        return view('payroll.show', compact('payroll'));
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

    /**
     * Export seluruh data penggajian ke file CSV (dapat dibuka di Excel).
     */
    public function export()
    {
        $payrolls = $this->payrollService->getAllPayroll();
        $payrolls->load('employee.jobrole'); // muat jabatan untuk kolom CSV

        $fileName = 'penggajian_' . now()->format('Y-m-d') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ];

        $columns = ['No', 'Nama Karyawan', 'Jabatan', 'Bulan', 'Tahun',
            'Gaji Pokok', 'Tunjangan', 'Potongan', 'Gaji Bersih', 'Status'];

        $callback = function () use ($payrolls, $columns) {
            $output = fopen('php://output', 'w');

            // BOM UTF-8 agar Excel membaca karakter dengan benar
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
}