<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Services\LeaveRequestService;
use Illuminate\Http\Request;

class LeaveRequestController extends Controller
{
    protected $leaveRequestService;

    public function __construct(LeaveRequestService $leaveRequestService)
    {
        $this->leaveRequestService = $leaveRequestService;
    }

    /**
     * Menampilkan seluruh data pengajuan cuti
     */
    public function index()
    {
        $leaveRequests = $this->leaveRequestService->getAllLeaveRequests()
            ->map(function ($leave) {
                $balance = $this->leaveRequestService->getLeaveBalance($leave->employee_id);
                $leave->remaining_days = $balance['remaining_days'];
                return $leave;
            });

        return view(
            'leave_request.index',
            compact('leaveRequests')
        );
    }

    /**
     * Menampilkan form tambah pengajuan cuti
     */
    public function create()
    {
        $employees = Employee::select('employee_code', 'name')->get();

        return view('leave_request.create', compact('employees'));
    }

    /**
     * Simpan pengajuan cuti baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id'     => 'required',
            'employee_name'   => 'required',
            'start_date'      => 'required|date',
            'end_date'        => 'required|date|after_or_equal:start_date',
            'reason'          => 'required',
            'status'          => 'required|in:Pending,Approved,Rejected',
        ]);

        $validated['submission_date'] = now();

        $this->leaveRequestService->createLeaveRequest($validated);

        return redirect()
            ->route('leave_request.index')
            ->with('success', 'Pengajuan cuti berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail pengajuan cuti
     */
    public function show($id)
    {
        $leaveRequest = $this->leaveRequestService->getLeaveRequestDetail($id);

        if (!$leaveRequest) {
            abort(404, 'Data pengajuan cuti tidak ditemukan');
        }

        return view(
            'leave_request.detail',
            compact('leaveRequest')
        );
    }

    public function balance(Request $request, $employeeId)
{
    $year = $request->query('year');

    $balance = $this->leaveRequestService->getLeaveBalance($employeeId, $year);

    return response()->json([
        'status' => 'success',
        'data' => $balance,
    ]);
}



    /**
     * Menampilkan form edit pengajuan cuti
     */
    public function edit($id)
    {
        $leaveRequest = $this->leaveRequestService->getLeaveRequestDetail($id);

        if (!$leaveRequest) {
            abort(404, 'Data pengajuan cuti tidak ditemukan');
        }

        return view('leave_request.edit', compact('leaveRequest'));
    }

    /**
     * Update data pengajuan cuti
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'employee_id'     => 'required',
            'employee_name'   => 'required',
            'start_date'      => 'required|date',
            'end_date'        => 'required|date|after_or_equal:start_date',
            'reason'          => 'required',
            'status'          => 'required|in:Pending,Approved,Rejected',
        ]);

        $leaveRequest = $this->leaveRequestService->updateLeaveRequest($id, $validated);

        if (!$leaveRequest) {
            abort(404, 'Data pengajuan cuti tidak ditemukan');
        }

        return redirect()
            ->route('leave_request.index')
            ->with('success', 'Data pengajuan cuti berhasil diperbarui.');
    }

    /**
     * Hapus data pengajuan cuti
     */
    public function destroy($id)
    {
        $deleted = $this->leaveRequestService->deleteLeaveRequest($id);

        if (!$deleted) {
            abort(404, 'Data pengajuan cuti tidak ditemukan');
        }

        return redirect()
            ->route('leave_request.index')
            ->with('success', 'Data pengajuan cuti berhasil dihapus.');
    }

}