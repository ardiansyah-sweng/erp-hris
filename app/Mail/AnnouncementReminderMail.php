<?php

namespace App\Mail;

use App\Models\Announcement;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AnnouncementReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public Announcement $announcement;

    public function __construct(Announcement $announcement)
    {
        $this->announcement = $announcement;
    }

    public function build()
    {
        return $this->from(auth()->user()->email ?? 'admin@erphris.com', 'ERP HRIS')
            ->subject('Pengumuman: ' . $this->announcement->title)
            ->view('emails.announcement-reminder');
    }
}