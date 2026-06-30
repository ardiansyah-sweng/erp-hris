<?php

namespace App\Services;

use App\Models\LeaveRequest;

class LeaveRequestService
{
    public function getAllLeaveRequests()
    {
        return LeaveRequest::all();
    }

    public function getLeaveRequestDetail($id)
    {
        return LeaveRequest::find($id);
    }

    public function createLeaveRequest(array $data)
    {
        return LeaveRequest::create($data);
    }

    public function updateLeaveRequest($id, array $data)
    {
        $leaveRequest = LeaveRequest::find($id);

        if (!$leaveRequest) {
            return null;
        }

        $leaveRequest->update([
            'employee_id' => $data['employee_id'],
            'employee_name' => $data['employee_name'],
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'reason' => $data['reason'],
            'status' => $data['status'],
        ]);

        return $leaveRequest;
    }

    public function destroyLeaveRequest($id)
    {
        $leaveRequest = LeaveRequest::find($id);

        if (!$leaveRequest) {
            return false;
        }

        return $leaveRequest->delete();
    }
}
