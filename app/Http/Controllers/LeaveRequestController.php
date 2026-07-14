<?php

namespace App\Http\Controllers;

use App\Services\LeaveRequestService;
use Illuminate\Http\Request;

class LeaveRequestController extends Controller
{
    protected $leaveRequestService;

    public function __construct(LeaveRequestService $leaveRequestService)
    {
        $this->leaveRequestService = $leaveRequestService;
    }

    /**
     * Menampilkan seluruh data pengajuan cuti
     */
    public function index()
    {
        $leaveRequests = $this->leaveRequestService->getAllLeaveRequests();

        return view(
            'leave_request.index',
            compact('leaveRequests')
        );
    }

    /**
     * Menampilkan detail pengajuan cuti
     */
    public function show($id)
    {
        $leaveRequest = $this->leaveRequestService->getLeaveRequestDetail($id);

        if (!$leaveRequest) {
            abort(404, 'Data pengajuan cuti tidak ditemukan');
        }

        return view(
            'leave_request.detail',
            compact('leaveRequest')
        );
    }

    /**
     * Kirim email reminder untuk seluruh pengajuan cuti yang masih pending.
     * Dipanggil dari tombol di halaman web (bukan lagi harus lewat `php artisan email:reminder-cuti`).
     */
    public function sendReminder()
    {
        $jumlah = $this->leaveRequestService->sendPendingLeaveReminder();

        if ($jumlah === 0) {
            return redirect()
                ->route('leave_request.index')
                ->with('info', 'Tidak ada pengajuan cuti yang pending, reminder tidak dikirim.');
        }

        return redirect()
            ->route('leave_request.index')
            ->with('success', "Email reminder berhasil dikirim untuk {$jumlah} pengajuan cuti.");
    }
}