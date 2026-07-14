<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\LeaveRequestService;

class SendLeaveReminderEmail extends Command
{
    protected $signature = 'email:reminder-cuti';

    protected $description = 'Kirim email reminder untuk pengajuan cuti yang masih pending';

    public function handle(LeaveRequestService $leaveRequestService)
    {
        $jumlah = $leaveRequestService->sendPendingLeaveReminder();

        if ($jumlah === 0) {
            $this->info('Tidak ada pengajuan cuti yang pending.');
            return;
        }

        $this->info('Email reminder berhasil dikirim untuk ' . $jumlah . ' pengajuan cuti.');
    }
}