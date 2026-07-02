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
    public function index(Request $request)
    {
        $search = $request->input('search');
        $leaveRequests = $this->leaveRequestService->getAllLeaveRequests($search);

        return view('leave_request.index', compact('leaveRequests', 'search'));
    }

    /**
     * Menampilkan form tambah pengajuan cuti
     */
    public function create()
    {
        $employees = Employee::orderBy('name')->get(['id', 'name']);

        return view('leave_request.create', compact('employees'));
    }

    /**
     * Menyimpan pengajuan cuti baru
     */
    public function store(Request $request)
    {
        $this->leaveRequestService->createLeaveRequest([
            'employee_id' => $request->employee_id,
            'employee_name' => $request->employee_name,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'reason' => $request->reason,
            'status' => 'Pending',
            'submission_date' => now(),
        ]);

        return redirect()->route('leave_request.index');
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

        return view('leave_request.detail', compact('leaveRequest'));
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
     * Memperbarui data pengajuan cuti
     */
    public function update(Request $request, $id)
    {
        $leaveRequest = $this->leaveRequestService->updateLeaveRequest($id, $request->all());

        if (!$leaveRequest) {
            abort(404, 'Data pengajuan cuti tidak ditemukan');
        }

        return redirect()->route('leave_request.index');
    }

    /**
     * Menghapus data pengajuan cuti
     */
    public function destroy($id)
    {
        $deleted = $this->leaveRequestService->destroyLeaveRequest($id);

        if (!$deleted) {
            abort(404, 'Data pengajuan cuti tidak ditemukan');
        }

        return redirect()->route('leave_request.index');
    }
}
