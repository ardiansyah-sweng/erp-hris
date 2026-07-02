<?php

namespace App\Services;

use App\Models\LeaveRequest;

class LeaveRequestService
{
    public function getAllLeaveRequests(?string $search = null)
    {
        return LeaveRequest::query()
            ->when($search, function ($query) use ($search) {
                $query->where('employee_name', 'like', "%{$search}%")
                    ->orWhere('employee_id', 'like', "%{$search}%");
            })
            ->latest()
            ->get();
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
