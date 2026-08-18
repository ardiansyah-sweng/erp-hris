<?php

namespace App\Services;

use App\Models\Overtime;
use App\Models\Employee;
use App\Models\Shift;
use Carbon\Carbon;

class OvertimeService
{
    /**
     * Ambil semua data lembur.
     */
    public function getAllOvertimes($filters = [])
    {
        $query = Overtime::with(['employee.jobrole', 'shift', 'approver']);

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['month']) && !empty($filters['year'])) {
            $query->whereMonth('date', $filters['month'])
                  ->whereYear('date', $filters['year']);
        }

        if (!empty($filters['employee_id'])) {
            $query->where('employee_id', $filters['employee_id']);
        }

        return $query->orderByDesc('date')->get();
    }

    /**
     * Buat data lembur baru.
     */
    public function createOvertime(array $data): Overtime
    {
        $employee = Employee::findOrFail($data['employee_id']);
        $shift = isset($data['shift_id']) ? Shift::find($data['shift_id']) : $employee->currentShift();

        $scheduledOut = $data['scheduled_out'] ?? ($shift ? $shift->end_time : '17:00');
        $actualOut = $data['actual_out'];

        $overtimeHours = $this->calculateOvertimeHours($scheduledOut, $actualOut);

        // Hitung upah per jam: Gaji Pokok / 173
        $latestPayroll = $employee->payrolls()->latest()->first();
        $basicSalary = $latestPayroll ? $latestPayroll->basic_salary : 0;
        $hourlyRate = $basicSalary > 0 ? round($basicSalary / 173, 2) : 0;

        $overtimePay = Overtime::calculatePay($hourlyRate, $overtimeHours);

        return Overtime::create([
            'employee_id'    => $data['employee_id'],
            'date'           => $data['date'],
            'shift_id'       => $shift ? $shift->id : null,
            'scheduled_out'  => $scheduledOut,
            'actual_out'     => $actualOut,
            'overtime_hours' => $overtimeHours,
            'hourly_rate'    => $hourlyRate,
            'overtime_pay'   => $overtimePay,
            'status'         => 'pending',
            'notes'          => $data['notes'] ?? null,
        ]);
    }

    /**
     * Approve lembur.
     */
    public function approveOvertime($id, $approvedBy): ?Overtime
    {
        $overtime = Overtime::find($id);

        if (!$overtime || $overtime->status !== 'pending') {
            return null;
        }

        $overtime->update([
            'status'      => 'approved',
            'approved_by' => $approvedBy,
        ]);

        return $overtime;
    }

    /**
     * Reject lembur.
     */
    public function rejectOvertime($id, $approvedBy): ?Overtime
    {
        $overtime = Overtime::find($id);

        if (!$overtime || $overtime->status !== 'pending') {
            return null;
        }

        $overtime->update([
            'status'      => 'rejected',
            'approved_by' => $approvedBy,
        ]);

        return $overtime;
    }

    /**
     * Hitung jam lembur berdasarkan selisih jam keluar.
     */
    public function calculateOvertimeHours(string $scheduledOut, string $actualOut): float
    {
        $scheduled = Carbon::createFromTimeString($scheduledOut);
        $actual = Carbon::createFromTimeString($actualOut);

        // Jika actual lebih awal dari scheduled, tidak ada lembur
        if ($actual->lte($scheduled)) {
            return 0;
        }

        $diffMinutes = $scheduled->diffInMinutes($actual);
        // Bulatkan ke 0.5 jam terdekat
        return round($diffMinutes / 60, 1);
    }

    /**
     * Ambil ringkasan lembur karyawan per bulan (untuk integrasi Payroll).
     */
    public function getEmployeeOvertimeSummary($employeeId, $month, $year): array
    {
        $overtimes = Overtime::where('employee_id', $employeeId)
            ->approved()
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->get();

        return [
            'total_hours' => $overtimes->sum('overtime_hours'),
            'total_pay'   => $overtimes->sum('overtime_pay'),
            'count'       => $overtimes->count(),
        ];
    }

    /**
     * Hapus data lembur (hanya jika masih pending).
     */
    public function deleteOvertime($id): bool
    {
        $overtime = Overtime::find($id);

        if (!$overtime || $overtime->status !== 'pending') {
            return false;
        }

        return $overtime->delete();
    }
}
