<?php

namespace App\Observers;

use App\Models\LeaveRequest;
use Illuminate\Support\Facades\DB;

class LeaveRequestObserver
{
    public function created(LeaveRequest $leaveRequest): void
    {
        DB::table('activity_logs')->insert([
            'user_email'  => auth()->user()->email ?? 'employee@erphris.com',
            'action'      => 'CREATE',
            'module'      => 'Leave & Permit',
            'description' => 'Membuat pengajuan cuti baru ID: ' . $leaveRequest->id . ' (Karyawan ID: ' . $leaveRequest->employee_id . ')',
            'created_at'  => now()
        ]);
    }

    public function updated(LeaveRequest $leaveRequest): void
    {
        $statusInfo = '';
        if ($leaveRequest->isDirty('status')) {
            $statusInfo = ' menjadi ' . strtoupper($leaveRequest->status);
        }

        DB::table('activity_logs')->insert([
            'user_email'  => auth()->user()->email ?? 'hrd@erphris.com',
            'action'      => 'UPDATE',
            'module'      => 'Leave & Permit',
            'description' => 'Memperbarui status/data pengajuan cuti ID: ' . $leaveRequest->id . $statusInfo,
            'created_at'  => now()
        ]);
    }

    public function deleted(LeaveRequest $leaveRequest): void
    {
        DB::table('activity_logs')->insert([
            'user_email'  => auth()->user()->email ?? 'admin@erphris.com',
            'action'      => 'DELETE',
            'module'      => 'Leave & Permit',
            'description' => 'Membatalkan/menghapus permanen data pengajuan cuti ID: ' . $leaveRequest->id,
            'created_at'  => now()
        ]);
    }
}