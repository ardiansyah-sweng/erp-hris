<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\JobRole;

class DashboardController extends Controller
{
    public function index()
    {
        $totalAktif = Employee::where('status', 'active')->count();
        $totalCuti  = Employee::where('status', 'cuti')->count();
        $totalJobRole = JobRole::count();

        $karyawanBaru = Employee::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $stats = [
            [
                'label' => 'Total Karyawan Aktif',
                'value' => $totalAktif,
                'sub'   => $totalAktif > 0 ? '+' . Employee::where('status', 'active')->whereMonth('created_at', now()->month)->count() . ' bulan ini' : '-',
                'color' => 'indigo',
                'icon'  => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z',
                'type'  => 'active',
            ],
            [
                'label' => 'Karyawan Cuti Hari Ini',
                'value' => $totalCuti,
                'sub'   => "dari {$totalAktif} karyawan",
                'color' => 'amber',
                'icon'  => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z',
                'type'  => 'cuti',
            ],
            [
                'label' => 'Total Job Role',
                'value' => $totalJobRole,
                'sub'   => 'Role tersedia',
                'color' => 'blue',
                'icon'  => 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10',
                'type'  => 'jobrole',
            ],
            [
                'label' => 'Karyawan Baru Bulan Ini',
                'value' => $karyawanBaru,
                'sub'   => now()->translatedFormat('F Y'),
                'color' => 'emerald',
                'icon'  => 'M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z',
                'type'  => 'baru',
            ],
        ];

        // Semua detail data langsung diambil di sini, tanpa perlu request tambahan (fetch/AJAX)
        $detailData = [
            'active' => Employee::where('status', 'active')
                ->select('id', 'name', 'role_id', 'status')
                ->get(),

            'cuti' => Employee::where('status', 'cuti')
                ->select('id', 'name', 'role_id', 'status')
                ->get(),

            'jobrole' => JobRole::select('id', 'role')->get(),

            'baru' => Employee::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->select('id', 'name', 'role_id', 'status', 'created_at')
                ->orderByDesc('created_at')
                ->get(),
        ];

        return view('dashboard', compact('stats', 'detailData'));
    }
}