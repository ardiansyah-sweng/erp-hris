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
    public function update(Request $request, $id)
{
    $leaveRequest = $this->leaveRequestService->updateLeaveRequest(
        $id,
        $request->all()
    );

    if (!$leaveRequest) {
        abort(404, 'Data pengajuan cuti tidak ditemukan');
    }

    return redirect('/leave-request');
}
public function destroy($id)
{
    $deleted = $this->leaveRequestService->destroyLeaveRequest($id);

    if (!$deleted) {
        abort(404, 'Data pengajuan cuti tidak ditemukan');
    }

    return redirect('/leave-request');
}
public function edit($id)
{
    $leaveRequest = $this->leaveRequestService
        ->getLeaveRequestDetail($id);

    if (!$leaveRequest) {
        abort(404);
    }

    return view(
        'leave_request.edit',
        compact('leaveRequest')
    );
}
}