<?php

namespace App\Services;

use App\Models\LeaveRequest;
use App\Mail\LeaveReminderMail;
use Illuminate\Support\Facades\Mail;

class LeaveRequestService
{
    public function getAllLeaveRequests()
    {
        return LeaveRequest::all();
    }

    public function getLeaveRequestDetail($id)
    {
        return LeaveRequest::find($id);
    }

    public function createLeaveRequest(array $data)
    {
        return LeaveRequest::create($data);
    }

    /**
     * Kirim email reminder untuk semua pengajuan cuti yang masih pending.
     * Dipakai bareng oleh Controller (trigger dari web) dan Artisan Command (trigger dari terminal/scheduler),
     * supaya logicnya cuma ada di satu tempat.
     *
     * @return int Jumlah pengajuan cuti pending yang di-remind
     */
    public function sendPendingLeaveReminder(): int
    {
        $pendingLeaves = LeaveRequest::where('status', 'Pending')->get();

        if ($pendingLeaves->isEmpty()) {
            return 0;
        }

        Mail::to('hr@erphris.com')->send(new LeaveReminderMail($pendingLeaves));

        return $pendingLeaves->count();
    }
}