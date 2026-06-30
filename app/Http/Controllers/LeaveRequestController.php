<?php

namespace App\Http\Controllers;

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
        $leaveRequests = $this->leaveRequestService->getAllLeaveRequests();

        return view(
            'leave_request.index',
            compact('leaveRequests')
        );
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

    /**
     * Menampilkan form edit pengajuan cuti
     */
    public function edit($id)
    {
        $dummyLeaveRequests = [
        [
            'id' => '1',
            'employee_id' => 'EMP001',
            'employee_name' => 'Susanti Wijaya',
            'start_date' => '2026-06-10',
            'end_date' => '2026-06-12',
            'reason' => 'Liburan keluarga',
            'status' => 'Pending',
        ],
        [
            'id' => '2',
            'employee_id' => 'EMP002',
            'employee_name' => 'Budi Santoso',
            'start_date' => '2026-06-15',
            'end_date' => '2026-06-18',
            'reason' => 'Keperluan pribadi',
            'status' => 'Approved',
        ],
        [
            'id' => '3',
            'employee_id' => 'EMP003',
            'employee_name' => 'Andi Wijaya',
            'start_date' => '2026-06-20',
            'end_date' => '2026-06-22',
            'reason' => 'Kunjungan keluarga',
            'status' => 'Rejected',
        ],
    ];

    $leaveRequest = collect($dummyLeaveRequests)->firstWhere('id', $id);

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
        return redirect()
            ->route('leave_request.index')
            ->with('success', 'Data cuti berhasil diperbarui.');
    }
}