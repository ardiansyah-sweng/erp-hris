<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Shift;
use App\Services\OvertimeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OvertimeController extends Controller
{
    protected $overtimeService;

    public function __construct(OvertimeService $overtimeService)
    {
        $this->overtimeService = $overtimeService;
    }

    public function index(Request $request)
    {
        $filters = [
            'status'      => $request->query('status'),
            'month'       => $request->query('month', now()->month),
            'year'        => $request->query('year', now()->year),
            'employee_id' => $request->query('employee_id'),
        ];

        $overtimes = $this->overtimeService->getAllOvertimes($filters);
        $employees = Employee::orderBy('name')->get();

        return view('overtime.index', compact('overtimes', 'employees', 'filters'));
    }

    public function create()
    {
        $employees = Employee::where('status', 'active')->orderBy('name')->get();
        $shifts = Shift::active()->get();

        return view('overtime.create', compact('employees', 'shifts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id'   => 'required|exists:employees,id',
            'date'          => 'required|date',
            'shift_id'      => 'nullable|exists:shifts,id',
            'scheduled_out' => 'required',
            'actual_out'    => 'required',
            'notes'         => 'nullable|string',
        ]);

        $overtime = $this->overtimeService->createOvertime($validated);

        DB::table('activity_logs')->insert([
            'user_email'  => auth()->user()->email ?? 'admin@erphris.com',
            'action'      => 'CREATE',
            'module'      => 'Overtime',
            'description' => 'Pengajuan lembur baru untuk Karyawan ID: ' . $overtime->employee_id . ' (' . $overtime->overtime_hours . ' jam)',
            'created_at'  => now()
        ]);

        return redirect()->route('overtime.index')->with('success', 'Pengajuan lembur berhasil disimpan.');
    }

    public function approve($id)
    {
        $userId = auth()->id() ?? 1;
        $overtime = $this->overtimeService->approveOvertime($id, $userId);

        if (!$overtime) {
            return redirect()->back()->with('error', 'Gagal menyetujui pengajuan lembur.');
        }

        DB::table('activity_logs')->insert([
            'user_email'  => auth()->user()->email ?? 'admin@erphris.com',
            'action'      => 'APPROVE',
            'module'      => 'Overtime',
            'description' => 'Menyetujui lembur ID: ' . $id,
            'created_at'  => now()
        ]);

        return redirect()->back()->with('success', 'Pengajuan lembur berhasil disetujui.');
    }

    public function reject($id)
    {
        $userId = auth()->id() ?? 1;
        $overtime = $this->overtimeService->rejectOvertime($id, $userId);

        if (!$overtime) {
            return redirect()->back()->with('error', 'Gagal menolak pengajuan lembur.');
        }

        DB::table('activity_logs')->insert([
            'user_email'  => auth()->user()->email ?? 'admin@erphris.com',
            'action'      => 'REJECT',
            'module'      => 'Overtime',
            'description' => 'Menolak lembur ID: ' . $id,
            'created_at'  => now()
        ]);

        return redirect()->back()->with('success', 'Pengajuan lembur berhasil ditolak.');
    }

    public function destroy($id)
    {
        $deleted = $this->overtimeService->deleteOvertime($id);

        if (!$deleted) {
            return redirect()->back()->with('error', 'Data lembur tidak dapat dihapus (mungkin sudah disetujui/ditolak).');
        }

        return redirect()->route('overtime.index')->with('success', 'Data lembur berhasil dihapus.');
    }
}
