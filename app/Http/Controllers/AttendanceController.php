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
}
