<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    /**
     * Endpoint API: mengembalikan seluruh data absensi dalam format JSON.
     */
    public function apiIndex()
    {
        $attendances = Attendance::with('employee')->get();

        return response()->json([
            'status' => 'success',
            'data'   => $attendances,
        ]);
    }

    /**
     * Menampilkan halaman daftar absensi.
     */
    public function index()
    {
        $attendances = Attendance::with('employee.jobrole')
            ->orderByDesc('date')
            ->get();

        return view('absensi.index', compact('attendances'));
    }

    /**
     * Menampilkan detail satu data absensi.
     */
    public function show($id)
    {
        $attendance = Attendance::with('employee.jobrole')->find($id);

        if (!$attendance) {
            abort(404, 'Data absensi tidak ditemukan');
        }

        return view('absensi.detail', compact('attendance'));
    }

    /**
     * Rekap presensi per periode (fitur baru - Laelatun).
     */
    public function recap(Request $request)
    {
        $startDate = $request->query('start_date', now()->subDays(7)->toDateString());
        $endDate = $request->query('end_date', now()->toDateString());

        $recap = Attendance::whereBetween('date', [$startDate, $endDate])
            ->selectRaw('employee_id, status, COUNT(*) as total')
            ->groupBy('employee_id', 'status')
            ->get()
            ->groupBy('employee_id')
            ->map(function ($rows, $employeeId) {
                $summary = ['present' => 0, 'absent' => 0, 'late' => 0, 'sick' => 0, 'leave' => 0];
                foreach ($rows as $row) {
                    $summary[$row->status] = (int) $row->total;
                }
                $employee = \App\Models\Employee::find($employeeId);
                return [
                    'employee_id' => (int) $employeeId,
                    'employee_name' => $employee->name ?? '-',
                    'summary' => $summary,
                    'total_records' => array_sum($summary),
                ];
            })
            ->values();

        return view('absensi.recap', compact('recap', 'startDate', 'endDate'));
    }
}
