<?php

namespace App\Observers;

use App\Models\Attendance;
use Illuminate\Support\Facades\DB;

class AttendanceObserver
{
    public function created(Attendance $attendance): void
    {
        DB::table('activity_logs')->insert([
            'user_email'  => auth()->user()->email ?? 'system@erphris.com',
            'action'      => 'CREATE',
            'module'      => 'Attendance',
            'description' => 'Mencatat absensi baru Karyawan ID: ' . $attendance->employee_id . ' (Status: ' . ($attendance->status ?? 'Hadir') . ')',
            'created_at'  => now()
        ]);
    }

    public function updated(Attendance $attendance): void
    {
        DB::table('activity_logs')->insert([
            'user_email'  => auth()->user()->email ?? 'admin@erphris.com',
            'action'      => 'UPDATE',
            'module'      => 'Attendance',
            'description' => 'Mengubah rincian/status absensi ID: ' . $attendance->id . ' untuk Karyawan ID: ' . $attendance->employee_id,
            'created_at'  => now()
        ]);
    }
}