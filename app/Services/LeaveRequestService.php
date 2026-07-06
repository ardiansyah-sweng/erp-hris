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
    public function getLeaveBalance($employeeId, $year = null, $annualQuota = 12)
{
    $year = $year ?: date('Y');

    $usedDays = LeaveRequest::where('employee_id', $employeeId)
        ->where('status', 'Approved')
        ->whereYear('start_date', $year)
        ->get()
        ->sum(function ($leave) {
            return \Carbon\Carbon::parse($leave->start_date)
                ->diffInDays(\Carbon\Carbon::parse($leave->end_date)) + 1;
        });

    return [
        'employee_id' => $employeeId,
        'year' => (int) $year,
        'annual_quota' => $annualQuota,
        'used_days' => $usedDays,
        'remaining_days' => max($annualQuota - $usedDays, 0),
    ];
}

}