<?php

namespace App\Services;

use App\Models\Employee;
use App\Models\LeaveRequest;
use Carbon\Carbon;

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
        $employee = Employee::where('employee_code', $data['employee_id'])->firstOrFail();
        $totalDays = $this->calculateTotalDays($data['start_date'], $data['end_date']);

        $this->validateLeaveBalance($employee, $totalDays);
        $this->validateOverlap($data['employee_id'], $data['start_date'], $data['end_date']);

        $data['submission_date'] = $data['submission_date'] ?? now();
        $data['status'] = 'Pending';

        $leaveRequest = LeaveRequest::create($data);

        return $leaveRequest;
    }

    public function updateLeaveRequest($id, array $data)
    {
        $leaveRequest = LeaveRequest::find($id);

        if (!$leaveRequest) {
            return false;
        }

        $totalDays = $this->calculateTotalDays($data['start_date'], $data['end_date']);

        $employee = Employee::where('employee_code', $data['employee_id'])->firstOrFail();

        if ($leaveRequest->status !== 'Approved') {
            $this->validateLeaveBalance($employee, $totalDays);
        }

        if ($data['start_date'] !== $leaveRequest->start_date->toDateString() ||
            $data['end_date'] !== $leaveRequest->end_date->toDateString()) {
            $this->validateOverlap($data['employee_id'], $data['start_date'], $data['end_date'], $id);
        }

        $oldStatus = $leaveRequest->status;
        $newStatus = $data['status'] ?? $leaveRequest->status;

        $leaveRequest->update($data);

        if ($newStatus === 'Approved' && $oldStatus !== 'Approved') {
            $this->decrementBalance($employee, $totalDays);
        } elseif ($newStatus !== 'Approved' && $oldStatus === 'Approved') {
            $this->restoreBalance($employee, $leaveRequest->total_days);
        }

        return $leaveRequest;
    }

    public function deleteLeaveRequest($id)
    {
        $leaveRequest = LeaveRequest::find($id);

        if (!$leaveRequest) {
            return false;
        }

        if ($leaveRequest->status === 'Approved') {
            $employee = Employee::where('employee_code', $leaveRequest->employee_id)->first();
            if ($employee) {
                $this->restoreBalance($employee, $leaveRequest->total_days);
            }
        }

        return $leaveRequest->delete();
    }

    public function getLeaveRequestsPaginated($perPage = 10, $search = null)
    {
        $query = LeaveRequest::query();

        if ($search) {
            $query->where('employee_name', 'like', "%{$search}%");
        }

        return $query->orderByDesc('created_at')->paginate($perPage);
    }

    private function calculateTotalDays($startDate, $endDate)
    {
        return Carbon::parse($startDate)->diffInDays(Carbon::parse($endDate)) + 1;
    }

    private function validateLeaveBalance(Employee $employee, int $totalDays)
    {
        $remaining = $employee->remaining_leave;

        if ($totalDays > $remaining) {
            throw new \Exception(
                "Sisa cuti tidak mencukupi. Sisa: {$remaining} hari, diajukan: {$totalDays} hari."
            );
        }
    }

    private function validateOverlap($employeeId, $startDate, $endDate, $excludeId = null)
    {
        $query = LeaveRequest::where('employee_id', $employeeId)
            ->where(function ($q) use ($startDate, $endDate) {
                $q->whereBetween('start_date', [$startDate, $endDate])
                  ->orWhereBetween('end_date', [$startDate, $endDate])
                  ->orWhere(function ($q) use ($startDate, $endDate) {
                      $q->where('start_date', '<=', $startDate)
                        ->where('end_date', '>=', $endDate);
                  });
            });

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        if ($query->exists()) {
            throw new \Exception(
                "Sudah ada pengajuan cuti di rentang tanggal tersebut."
            );
        }
    }

    private function decrementBalance(Employee $employee, int $totalDays)
    {
        if (!$employee->relationLoaded('leaveRequests')) {
            $employee->unsetRelation('leaveRequests');
        }
    }

    private function restoreBalance(Employee $employee, int $totalDays)
    {
        if (!$employee->relationLoaded('leaveRequests')) {
            $employee->unsetRelation('leaveRequests');
        }
    }
}
