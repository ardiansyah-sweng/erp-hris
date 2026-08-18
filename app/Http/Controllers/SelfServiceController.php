<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Overtime;
use App\Models\Payroll;
use App\Models\Reimbursement;
use App\Models\Shift;
use App\Services\OvertimeService;
use App\Services\PayrollService;
use App\Services\ReimbursementService;
use App\Services\SelfServiceService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SelfServiceController extends Controller
{
    protected $selfServiceService;
    protected $overtimeService;
    protected $reimbursementService;

    public function __construct(
        SelfServiceService $selfServiceService,
        OvertimeService $overtimeService,
        ReimbursementService $reimbursementService
    ) {
        $this->selfServiceService = $selfServiceService;
        $this->overtimeService = $overtimeService;
        $this->reimbursementService = $reimbursementService;
    }

    /**
     * Helper untuk mendapatkan employee_id pengguna yang sedang login.
     * Jika user belum terhubung ke Employee, ambil Employee pertama sebagai fallback/demo.
     */
    private function getEmployeeId()
    {
        $user = Auth::user();
        if ($user && $user->employee_id) {
            return $user->employee_id;
        }

        // Fallback: Ambil karyawan pertama jika belum di-link
        $firstEmp = Employee::first();
        return $firstEmp ? $firstEmp->id : 1;
    }

    public function dashboard()
    {
        $employeeId = $this->getEmployeeId();
        $data = $this->selfServiceService->getEmployeeDashboardData($employeeId);

        return view('self-service.dashboard', compact('data'));
    }

    public function schedule(Request $request)
    {
        $employeeId = $this->getEmployeeId();
        $month = $request->query('month', now()->month);
        $year = $request->query('year', now()->year);

        $scheduleData = $this->selfServiceService->getEmployeeSchedule($employeeId, $month, $year);

        return view('self-service.schedule', compact('scheduleData'));
    }

    public function overtimeIndex()
    {
        $employeeId = $this->getEmployeeId();
        $overtimes = Overtime::where('employee_id', $employeeId)
            ->with('shift')
            ->orderByDesc('date')
            ->get();

        $shifts = Shift::active()->get();
        $employee = Employee::find($employeeId);

        return view('self-service.overtime', compact('overtimes', 'shifts', 'employee'));
    }

    public function overtimeStore(Request $request)
    {
        $employeeId = $this->getEmployeeId();

        $validated = $request->validate([
            'date'          => 'required|date',
            'shift_id'      => 'nullable|exists:shifts,id',
            'scheduled_out' => 'required',
            'actual_out'    => 'required',
            'notes'         => 'nullable|string',
        ]);

        $validated['employee_id'] = $employeeId;

        $this->overtimeService->createOvertime($validated);

        return redirect()->route('self-service.overtime')->with('success', 'Pengajuan lembur berhasil dikirim.');
    }

    public function reimbursementIndex()
    {
        $employeeId = $this->getEmployeeId();
        $reimbursements = Reimbursement::where('employee_id', $employeeId)
            ->orderByDesc('submission_date')
            ->get();

        $categories = Reimbursement::CATEGORIES;
        $employee = Employee::find($employeeId);

        return view('self-service.reimbursement', compact('reimbursements', 'categories', 'employee'));
    }

    public function reimbursementStore(Request $request)
    {
        $employeeId = $this->getEmployeeId();

        $validated = $request->validate([
            'category'        => 'required|in:transport,medical,meal,training,other',
            'title'           => 'required|string|max:255',
            'description'     => 'nullable|string',
            'amount'          => 'required|numeric|min:1',
            'submission_date' => 'required|date',
            'receipt'         => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $validated['employee_id'] = $employeeId;

        if ($request->hasFile('receipt')) {
            $path = $request->file('receipt')->store('receipts', 'public');
            $validated['receipt_path'] = $path;
        }

        $this->reimbursementService->createReimbursement($validated);

        return redirect()->route('self-service.reimbursement')->with('success', 'Pengajuan reimbursement berhasil dikirim.');
    }

    public function payslipIndex()
    {
        $employeeId = $this->getEmployeeId();
        $payslips = $this->selfServiceService->getEmployeePayslips($employeeId);

        return view('self-service.payslip', compact('payslips'));
    }

    public function payslipDownload($id)
    {
        $employeeId = $this->getEmployeeId();
        $payroll = Payroll::where('employee_id', $employeeId)->with('employee.jobrole')->findOrFail($id);

        $pdf = Pdf::loadView('payroll.pdf', compact('payroll'));
        $fileName = 'Slip_Gaji_' . $payroll->month . '_' . $payroll->year . '.pdf';

        return $pdf->download($fileName);
    }
}
