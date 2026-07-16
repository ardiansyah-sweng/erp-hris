<?php

namespace App\Http\Controllers;

use App\Mail\AnnouncementReminderMail;
use App\Models\Employee;
use App\Services\AnnouncementService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

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
        return view('announcement.index', compact('announcements'));
    }

    public function create()
    {
        return view('announcement.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'        => 'required|string|max:255',
            'content'      => 'required|string',
            'publish_date' => 'required|date',
            'status'       => 'required|in:Aktif,Draft',
        ]);

        $announcement = $this->announcementService->createAnnouncement($validated);

        DB::table('activity_logs')->insert([
            'user_email'  => auth()->user()->email ?? 'admin@erphris.com',
            'action'      => 'CREATE',
            'module'      => 'Announcement',
            'description' => 'Membuat pengumuman: ' . $announcement->title,
            'created_at'  => now(),
        ]);

        return redirect()->route('announcement.index')
            ->with('success', 'Pengumuman berhasil ditambahkan.');
    }

    public function show(int $id)
    {
        $announcement = $this->announcementService->getAnnouncementById($id);

        if (!$announcement) {
            abort(404);
        }

        return view('announcement.show', compact('announcement'));
    }

    public function edit(int $id)
    {
        $announcement = $this->announcementService->getAnnouncementById($id);

        if (!$announcement) {
            abort(404);
        }

        return view('announcement.edit', compact('announcement'));
    }

    public function update(Request $request, int $id)
    {
        $validated = $request->validate([
            'title'        => 'required|string|max:255',
            'content'      => 'required|string',
            'publish_date' => 'required|date',
            'status'       => 'required|in:Aktif,Draft',
        ]);

        $announcement = $this->announcementService->updateAnnouncement($id, $validated);

        if (!$announcement) {
            abort(404);
        }

        DB::table('activity_logs')->insert([
            'user_email'  => auth()->user()->email ?? 'admin@erphris.com',
            'action'      => 'UPDATE',
            'module'      => 'Announcement',
            'description' => 'Memperbarui pengumuman: ' . $announcement->title,
            'created_at'  => now(),
        ]);

        return redirect()->route('announcement.index')
            ->with('success', 'Pengumuman berhasil diperbarui.');
    }

    public function destroy(int $id)
    {
        $announcement = $this->announcementService->deleteAnnouncement($id);

        if (!$announcement) {
            return response()->json([
                'payload' => [
                    'statusCode' => 404,
                    'message' => 'Announcement not found',
                ],
            ], 404);
        }

        DB::table('activity_logs')->insert([
            'user_email'  => auth()->user()->email ?? 'admin@erphris.com',
            'action'      => 'DELETE',
            'module'      => 'Announcement',
            'description' => 'Menghapus pengumuman: ' . $announcement->title,
            'created_at'  => now(),
        ]);

        return redirect()->route('announcement.index')
            ->with('success', 'Pengumuman berhasil dihapus.');
    }

    public function sendReminder($id)
    {
        $announcement = \App\Models\Announcement::findOrFail($id);
        $employees = Employee::whereNotNull('email')->get();
        $emails = $employees->pluck('email')->toArray();

        if (empty($emails)) {
            return redirect()->route('announcement.index')
                ->with('success', 'Tidak ada karyawan dengan email terdaftar.');
        }

        Mail::to($emails)->send(new AnnouncementReminderMail($announcement));

        return redirect()->route('announcement.index')
            ->with('success', 'Reminder berhasil dikirim ke ' . count($emails) . ' karyawan.');
    }
}