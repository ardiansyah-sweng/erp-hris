<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use Barryvdh\DomPDF\Facade\Pdf;
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

        $recap = $this->buildRecap($startDate, $endDate);

        return view('absensi.recap', compact('recap', 'startDate', 'endDate'));
    }

    /**
     * Export rekap absensi ke PDF.
     */
    public function exportRecap(Request $request)
    {
        $startDate = $request->query('start_date', now()->subDays(7)->toDateString());
        $endDate = $request->query('end_date', now()->toDateString());

        $recap = $this->buildRecap($startDate, $endDate);

        $pdf = Pdf::loadView('absensi.pdf-recap', compact('recap', 'startDate', 'endDate'));

        return $pdf->download("rekap-absensi-{$startDate}-{$endDate}.pdf");
    }

    /**
     * Build recap data for a given period.
     */
    private function buildRecap($startDate, $endDate)
    {
        return Attendance::whereBetween('date', [$startDate, $endDate])
            ->selectRaw('employee_id, status, COUNT(*) as total')
            ->groupBy('employee_id', 'status')
            ->get()
            ->groupBy('employee_id')
            ->map(function ($rows, $employeeId) {
                $summary = ['present' => 0, 'absent' => 0, 'late' => 0, 'sick' => 0, 'leave' => 0];
                foreach ($rows as $row) {
                    $summary[$row->status] = (int) $row->total;
                }
                $employee = Employee::find($employeeId);
                return [
                    'employee_id' => (int) $employeeId,
                    'employee_name' => $employee->name ?? '-',
                    'summary' => $summary,
                    'total_records' => array_sum($summary),
                ];
            })
            ->values();
    }
}
