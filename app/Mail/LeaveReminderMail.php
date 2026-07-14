<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LeaveReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $leaveRequests;

    public function __construct($leaveRequests)
    {
        $this->leaveRequests = $leaveRequests;
    }

    public function build()
    {
        return $this->subject('Reminder: Ada Pengajuan Cuti yang Belum Diproses')
            ->view('emails.leave-reminder');
    }
}
