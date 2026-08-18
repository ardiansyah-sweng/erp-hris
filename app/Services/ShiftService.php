<?php

namespace App\Services;

use App\Models\Shift;
use App\Models\Employee;
use App\Models\EmployeeShift;
use Exception;

class ShiftService
{
    /**
     * Ambil semua data shift.
     */
    public function getAllShifts()
    {
        return Shift::orderBy('name')->get();
    }

    /**
     * Ambil shift aktif saja.
     */
    public function getActiveShifts()
    {
        return Shift::active()->orderBy('name')->get();
    }

    /**
     * Buat shift baru.
     */
    public function createShift(array $data): Shift
    {
        return Shift::create([
            'name'        => $data['name'],
            'start_time'  => $data['start_time'],
            'end_time'    => $data['end_time'],
            'total_hours' => $data['total_hours'] ?? 8,
            'is_active'   => $data['is_active'] ?? true,
        ]);
    }

    /**
     * Update shift.
     */
    public function updateShift($id, array $data): Shift
    {
        $shift = Shift::findOrFail($id);
        $shift->update($data);
        return $shift;
    }

    /**
     * Hapus shift (validasi: tidak boleh ada assignment aktif).
     */
    public function deleteShift($id): array
    {
        $shift = Shift::find($id);

        if (!$shift) {
            return ['statusCode' => 404, 'message' => 'Shift tidak ditemukan.'];
        }

        $activeAssignments = EmployeeShift::where('shift_id', $id)->active()->count();
        if ($activeAssignments > 0) {
            return [
                'statusCode' => 409,
                'message'    => "Shift tidak dapat dihapus karena masih digunakan oleh {$activeAssignments} karyawan.",
            ];
        }

        $shift->delete();

        return ['statusCode' => 200, 'message' => 'Shift berhasil dihapus.'];
    }

    /**
     * Assign shift ke karyawan.
     */
    public function assignShiftToEmployee(array $data): EmployeeShift
    {
        // Nonaktifkan assignment sebelumnya (tutup end_date)
        EmployeeShift::where('employee_id', $data['employee_id'])
            ->whereNull('end_date')
            ->update(['end_date' => $data['effective_date']]);

        return EmployeeShift::create([
            'employee_id'    => $data['employee_id'],
            'shift_id'       => $data['shift_id'],
            'effective_date' => $data['effective_date'],
            'end_date'       => $data['end_date'] ?? null,
        ]);
    }

    /**
     * Ambil shift aktif karyawan saat ini.
     */
    public function getEmployeeCurrentShift($employeeId): ?Shift
    {
        $employee = Employee::find($employeeId);
        return $employee ? $employee->currentShift() : null;
    }

    /**
     * Ambil semua assignment shift dengan eager loading.
     */
    public function getAllAssignments()
    {
        return EmployeeShift::with(['employee', 'shift'])
            ->orderByDesc('effective_date')
            ->get();
    }

    /**
     * Hapus assignment shift.
     */
    public function removeAssignment($id): bool
    {
        $assignment = EmployeeShift::find($id);
        if (!$assignment) {
            return false;
        }
        return $assignment->delete();
    }
}
