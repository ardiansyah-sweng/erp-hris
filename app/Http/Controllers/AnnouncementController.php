<?php

namespace App\Http\Controllers;

use App\Services\AnnouncementService;

class AnnouncementController extends Controller
{
    protected $announcementService;

    public function __construct(AnnouncementService $announcementService)
    {
        $this->announcementService = $announcementService;
    }

    public function index()
    {
        $announcements = $this->announcementService->getAllAnnouncements();

        return view(
            'announcement.index',
            compact('announcements')
        );
    }

    public function create()
    {
        return view('announcement.create');
    }

    public function edit($id)
    {
        $announcement = $this->announcementService->getAnnouncementById($id);

        abort_if(!$announcement, 404);

        return view(
            'announcement.edit',
            compact('announcement')
        );
    }
}