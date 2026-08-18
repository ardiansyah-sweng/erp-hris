<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Services\ShiftService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShiftController extends Controller
{
    protected $shiftService;

    public function __construct(ShiftService $shiftService)
    {
        $this->shiftService = $shiftService;
    }

    public function index()
    {
        $shifts = $this->shiftService->getAllShifts();
        $assignments = $this->shiftService->getAllAssignments();
        $employees = Employee::orderBy('name')->get();

        return view('shift.index', compact('shifts', 'assignments', 'employees'));
    }

    public function create()
    {
        return view('shift.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'start_time'  => 'required|date_format:H:i',
            'end_time'    => 'required|date_format:H:i',
            'total_hours' => 'required|numeric|min:1|max:24',
            'is_active'   => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $shift = $this->shiftService->createShift($validated);

        DB::table('activity_logs')->insert([
            'user_email'  => auth()->user()->email ?? 'admin@erphris.com',
            'action'      => 'CREATE',
            'module'      => 'Shift',
            'description' => 'Membuat shift baru: ' . $shift->name . ' (' . $shift->start_time . ' - ' . $shift->end_time . ')',
            'created_at'  => now()
        ]);

        return redirect()->route('shifts.index')->with('success', 'Shift kerja berhasil dibuat.');
    }

    public function edit($id)
    {
        $shift = \App\Models\Shift::findOrFail($id);
        return view('shift.edit', compact('shift'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'start_time'  => 'required',
            'end_time'    => 'required',
            'total_hours' => 'required|numeric|min:1|max:24',
            'is_active'   => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $shift = $this->shiftService->updateShift($id, $validated);

        DB::table('activity_logs')->insert([
            'user_email'  => auth()->user()->email ?? 'admin@erphris.com',
            'action'      => 'UPDATE',
            'module'      => 'Shift',
            'description' => 'Memperbarui data shift ID: ' . $id,
            'created_at'  => now()
        ]);

        return redirect()->route('shifts.index')->with('success', 'Shift kerja berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $result = $this->shiftService->deleteShift($id);

        if ($result['statusCode'] !== 200) {
            return redirect()->back()->with('error', $result['message']);
        }

        DB::table('activity_logs')->insert([
            'user_email'  => auth()->user()->email ?? 'admin@erphris.com',
            'action'      => 'DELETE',
            'module'      => 'Shift',
            'description' => 'Menghapus shift ID: ' . $id,
            'created_at'  => now()
        ]);

        return redirect()->route('shifts.index')->with('success', $result['message']);
    }

    public function assignStore(Request $request)
    {
        $validated = $request->validate([
            'employee_id'    => 'required|exists:employees,id',
            'shift_id'       => 'required|exists:shifts,id',
            'effective_date' => 'required|date',
            'end_date'       => 'nullable|date|after_or_equal:effective_date',
        ]);

        $assignment = $this->shiftService->assignShiftToEmployee($validated);

        DB::table('activity_logs')->insert([
            'user_email'  => auth()->user()->email ?? 'admin@erphris.com',
            'action'      => 'CREATE',
            'module'      => 'Shift Assignment',
            'description' => 'Meng-assign shift ID ' . $validated['shift_id'] . ' ke Karyawan ID ' . $validated['employee_id'],
            'created_at'  => now()
        ]);

        return redirect()->route('shifts.index')->with('success', 'Assignment shift berhasil disimpan.');
    }

    public function assignDestroy($id)
    {
        $this->shiftService->removeAssignment($id);

        return redirect()->route('shifts.index')->with('success', 'Assignment shift berhasil dihapus.');
    }
}
