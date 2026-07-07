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
     * Bisa difilter berdasarkan tanggal dan status (fitur baru - Laelatun).
     */
    public function index(Request $request)
    {
        $query = Attendance::with('employee.jobrole');

        if ($request->filled('date')) {
            $query->whereDate('date', $request->query('date'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->query('status'));
        }

        $attendances = $query->orderByDesc('date')->get();

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
}