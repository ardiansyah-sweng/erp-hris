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

    public function deleteLeaveRequest($id)
    {
        $leaveRequest = LeaveRequest::find($id);

        if (!$leaveRequest) {
            return false;
        }

        return $leaveRequest->delete();
    }

    public function updateLeaveRequest($id, array $data)
    {
        $leaveRequest = LeaveRequest::find($id);

        if (!$leaveRequest) {
            return false;
        }

        $leaveRequest->update($data);

        return $leaveRequest;
    }
}