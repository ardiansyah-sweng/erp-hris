<?php

namespace App\Services;

use App\Models\Employee;
use App\Models\Payroll;
use App\Models\Overtime;
use App\Models\Reimbursement;

class SelfServiceService
{
    /**
     * Data ringkasan dashboard karyawan.
     */
    public function getEmployeeDashboardData($employeeId): array
    {
        $employee = Employee::with('jobrole')->findOrFail($employeeId);
        $currentShift = $employee->currentShift();
        $currentMonth = now()->month;
        $currentYear = now()->year;

        // Sisa cuti
        $remainingLeave = $employee->remaining_leave;

        // Total lembur bulan ini (approved)
        $overtimeThisMonth = Overtime::where('employee_id', $employeeId)
            ->approved()
            ->whereMonth('date', $currentMonth)
            ->whereYear('date', $currentYear)
            ->get();

        // Klaim pending
        $pendingReimbursements = Reimbursement::where('employee_id', $employeeId)
            ->pending()
            ->count();

        // Total klaim approved bulan ini
        $approvedReimbursementThisMonth = Reimbursement::where('employee_id', $employeeId)
            ->approved()
            ->whereMonth('submission_date', $currentMonth)
            ->whereYear('submission_date', $currentYear)
            ->sum('amount');

        return [
            'employee'               => $employee,
            'current_shift'          => $currentShift,
            'remaining_leave'        => $remainingLeave,
            'overtime_hours_month'   => $overtimeThisMonth->sum('overtime_hours'),
            'overtime_pay_month'     => $overtimeThisMonth->sum('overtime_pay'),
            'overtime_count_month'   => $overtimeThisMonth->count(),
            'pending_reimbursements' => $pendingReimbursements,
            'approved_reimbursement_month' => $approvedReimbursementThisMonth,
        ];
    }

    /**
     * Jadwal shift karyawan per bulan.
     */
    public function getEmployeeSchedule($employeeId, $month = null, $year = null): array
    {
        $month = $month ?? now()->month;
        $year = $year ?? now()->year;

        $employee = Employee::findOrFail($employeeId);
        $currentShift = $employee->currentShift();

        // Buat kalender shift untuk bulan ini
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $schedule = [];

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = sprintf('%04d-%02d-%02d', $year, $month, $day);
            $dayOfWeek = date('N', strtotime($date)); // 1=Monday, 7=Sunday

            $schedule[] = [
                'date'       => $date,
                'day_name'   => date('D', strtotime($date)),
                'is_weekend' => $dayOfWeek >= 6,
                'shift'      => ($dayOfWeek < 6 && $currentShift) ? $currentShift : null,
            ];
        }

        return [
            'employee'      => $employee,
            'current_shift' => $currentShift,
            'month'         => $month,
            'year'          => $year,
            'schedule'      => $schedule,
        ];
    }

    /**
     * Daftar slip gaji karyawan.
     */
    public function getEmployeePayslips($employeeId)
    {
        return Payroll::where('employee_id', $employeeId)
            ->orderByDesc('year')
            ->orderByDesc('month')
            ->get();
    }
}
