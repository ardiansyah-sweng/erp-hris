<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\LeaveRequest;
use App\Models\User;
use App\Mail\LeaveReminderMail;
use Illuminate\Support\Facades\Mail;

class SendLeaveReminderEmail extends Command
{
    /**
     * Fitur baru: kirim email reminder cuti pending (Laelatun).
     */
    protected $signature = 'email:reminder-cuti';

    protected $description = 'Kirim email reminder untuk pengajuan cuti yang masih pending';

    public function handle()
    {
        $pendingLeaves = LeaveRequest::where('status', 'Pending')->get();

        if ($pendingLeaves->isEmpty()) {
            $this->info('Tidak ada pengajuan cuti yang pending.');
            return;
        }

        $recipientEmails = User::pluck('email')->toArray();

        if (empty($recipientEmails)) {
            $this->error('Tidak ada user/admin terdaftar untuk menerima email.');
            return;
        }

        Mail::to($recipientEmails)->send(new LeaveReminderMail($pendingLeaves));

        $this->info('Email reminder berhasil dikirim ke ' . count($recipientEmails) . ' admin, untuk ' . $pendingLeaves->count() . ' pengajuan cuti.');
    }
}