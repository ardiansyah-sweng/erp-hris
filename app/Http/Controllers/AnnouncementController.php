<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Announcement;
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

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'         => 'required|string|max:255',
            'content'       => 'required|string',
            'publish_date'  => 'required|date',
            'status'        => 'required|string',
        ]);

        Announcement::create($validated);

        return redirect()
            ->route('announcement.index')
            ->with('success', 'Pengumuman berhasil ditambahkan.');
    }

    public function show($id)
    {
        $announcement = $this->announcementService->getAnnouncementById($id);

        abort_if(!$announcement, 404);

        return view(
            'announcement.show',
            compact('announcement')
        );
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

    public function update(Request $request, Announcement $announcement)
    {
        $validated = $request->validate([
            'title'         => 'required|string|max:255',
            'content'       => 'required|string',
            'publish_date'  => 'required|date',
            'status'        => 'required|string',
        ]);

        $announcement->update($validated);

        return redirect()
            ->route('announcement.index')
            ->with('success', 'Pengumuman berhasil diperbarui.');
    }

    public function destroy(Announcement $announcement)
    {
        $announcement->delete();

        return redirect()
            ->route('announcement.index')
            ->with('success', 'Pengumuman berhasil dihapus.');
    }
}