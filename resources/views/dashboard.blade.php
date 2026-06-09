@extends('layouts.app')

@section('title', 'Dashboard - ERP HRIS')

@section('content')

@php
    $stats = [
        ['label' => 'Total Karyawan Aktif', 'value' => 128, 'sub' => '+3 bulan ini', 'color' => 'indigo', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
        ['label' => 'Karyawan Cuti Hari Ini', 'value' => 7, 'sub' => 'dari 128 karyawan', 'color' => 'amber', 'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
        ['label' => 'Total Job Role', 'value' => 24, 'sub' => '6 departemen', 'color' => 'blue', 'icon' => 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10'],
        ['label' => 'Karyawan Baru Bulan Ini', 'value' => 5, 'sub' => 'April 2026', 'color' => 'emerald', 'icon' => 'M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z'],
    ];

    $attendanceData = [
        ['day' => 'Sen', 'hadir' => 118, 'total' => 128],
        ['day' => 'Sel', 'hadir' => 121, 'total' => 128],
        ['day' => 'Rab', 'hadir' => 115, 'total' => 128],
        ['day' => 'Kam', 'hadir' => 123, 'total' => 128],
        ['day' => 'Jum', 'hadir' => 119, 'total' => 128],
        ['day' => 'Sab', 'hadir' => 42,  'total' => 128],
        ['day' => 'Min', 'hadir' => 0,   'total' => 128],
    ];

    $departments = [
        ['name' => 'IT',              'count' => 38, 'color' => 'bg-indigo-500'],
        ['name' => 'Human Resources', 'count' => 15, 'color' => 'bg-blue-500'],
        ['name' => 'Product',         'count' => 22, 'color' => 'bg-violet-500'],
        ['name' => 'Data',            'count' => 19, 'color' => 'bg-cyan-500'],
        ['name' => 'Finance',         'count' => 20, 'color' => 'bg-emerald-500'],
        ['name' => 'Operations',      'count' => 14, 'color' => 'bg-amber-500'],
    ];

    $totalDept = array_sum(array_column($departments, 'count'));

    $onLeaveToday = [
        ['name' => 'Rina Kusuma',    'role' => 'HR Manager',       'dept' => 'Human Resources', 'until' => '24 Apr 2026'],
        ['name' => 'Budi Santoso',   'role' => 'Data Analyst',     'dept' => 'Data',            'until' => '22 Apr 2026'],
        ['name' => 'Dewi Anggraini', 'role' => 'QA Engineer',      'dept' => 'IT',              'until' => '23 Apr 2026'],
        ['name' => 'Fajar Nugroho',  'role' => 'Finance Officer',  'dept' => 'Finance',         'until' => '25 Apr 2026'],
    ];

    $newEmployees = [
        ['name' => 'Ahmad Fauzi',    'role' => 'Software Engineer', 'dept' => 'IT',      'joined' => '18 Apr 2026'],
        ['name' => 'Siti Rahayu',    'role' => 'Product Designer',  'dept' => 'Product', 'joined' => '15 Apr 2026'],
        ['name' => 'Rizky Pratama',  'role' => 'Data Engineer',     'dept' => 'Data',    'joined' => '10 Apr 2026'],
        ['name' => 'Laila Nurfitri', 'role' => 'HR Specialist',     'dept' => 'Human Resources', 'joined' => '7 Apr 2026'],
        ['name' => 'Hendra Wijaya',  'role' => 'DevOps Engineer',   'dept' => 'IT',      'joined' => '2 Apr 2026'],
    ];

    $upcomingBirthdays = [
        ['name' => 'Citra Lestari',  'dept' => 'Finance',  'date' => '22 Apr'],
        ['name' => 'Doni Setiawan',  'dept' => 'IT',       'date' => '25 Apr'],
        ['name' => 'Mega Putri',     'dept' => 'Product',  'date' => '28 Apr'],
    ];

    $expiringContracts = [
        ['name' => 'Yusuf Hakim',    'role' => 'Data Analyst',    'expires' => '30 Apr 2026'],
        ['name' => 'Nita Safitri',   'role' => 'QA Tester',       'expires' => '15 Mei 2026'],
        ['name' => 'Bagas Wicaksono','role' => 'Frontend Dev',    'expires' => '31 Mei 2026'],
    ];

    $colorMap = [
        'indigo'  => ['bg' => 'bg-indigo-50',  'text' => 'text-indigo-600',  'val' => 'text-indigo-700'],
        'amber'   => ['bg' => 'bg-amber-50',   'text' => 'text-amber-600',   'val' => 'text-amber-700'],
        'blue'    => ['bg' => 'bg-blue-50',    'text' => 'text-blue-600',    'val' => 'text-blue-700'],
        'emerald' => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-600', 'val' => 'text-emerald-700'],
    ];
@endphp

<!-- Page Header -->
<div class="mb-8">
    <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Dashboard</h1>
    <p class="mt-1 text-sm text-gray-500">Selamat datang kembali! Berikut ringkasan kondisi SDM perusahaan hari ini.</p>
</div>

<!-- Stat Cards -->
<div class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-4 mb-8">
    @foreach($stats as $stat)
    @php $c = $colorMap[$stat['color']]; @endphp
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 flex flex-col gap-3 hover:-translate-y-1 transition-transform duration-300">
        <div class="flex items-center justify-between">
            <p class="text-sm font-medium text-gray-500">{{ $stat['label'] }}</p>
            <div class="p-2.5 rounded-xl {{ $c['bg'] }} {{ $c['text'] }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $stat['icon'] }}"/>
                </svg>
            </div>
        </div>
        <div class="flex items-baseline gap-2">
            <span class="text-3xl font-bold text-gray-900">{{ $stat['value'] }}</span>
            <span class="text-xs font-medium {{ $c['text'] }}">{{ $stat['sub'] }}</span>
        </div>
    </div>
    @endforeach
</div>

<!-- Charts Row -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

    <!-- Attendance Bar Chart -->
    <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-base font-semibold text-gray-900">Kehadiran 7 Hari Terakhir</h2>
                <p class="text-xs text-gray-400 mt-0.5">Jumlah karyawan hadir per hari</p>
            </div>
            <span class="text-xs font-medium text-indigo-600 bg-indigo-50 px-3 py-1 rounded-full">Minggu Ini</span>
        </div>
        <div class="flex items-end gap-3 h-40">
            @foreach($attendanceData as $d)
            @php $pct = $d['total'] > 0 ? ($d['hadir'] / $d['total']) * 100 : 0; @endphp
            <div class="flex-1 flex flex-col items-center gap-1.5">
                <span class="text-xs text-gray-500 font-medium">{{ $d['hadir'] }}</span>
                <div class="w-full rounded-t-lg transition-all duration-500
                    {{ $pct >= 90 ? 'bg-indigo-500' : ($pct >= 50 ? 'bg-indigo-300' : 'bg-gray-200') }}"
                     style="height: {{ max($pct, 4) }}%">
                </div>
                <span class="text-xs text-gray-400">{{ $d['day'] }}</span>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Department Distribution -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <div class="mb-5">
            <h2 class="text-base font-semibold text-gray-900">Distribusi Departemen</h2>
            <p class="text-xs text-gray-400 mt-0.5">Total {{ $totalDept }} karyawan</p>
        </div>
        <div class="space-y-3">
            @foreach($departments as $dept)
            @php $pct = round(($dept['count'] / $totalDept) * 100); @endphp
            <div>
                <div class="flex justify-between items-center mb-1">
                    <span class="text-xs font-medium text-gray-700">{{ $dept['name'] }}</span>
                    <span class="text-xs text-gray-400">{{ $dept['count'] }} <span class="text-gray-300">({{ $pct }}%)</span></span>
                </div>
                <div class="h-1.5 bg-gray-100 rounded-full overflow-hidden">
                    <div class="{{ $dept['color'] }} h-full rounded-full transition-all duration-500" style="width: {{ $pct }}%"></div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Bottom Row -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">

    <!-- Karyawan Cuti Hari Ini -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
            <h2 class="text-base font-semibold text-gray-900">Cuti Hari Ini</h2>
            <span class="text-xs font-semibold bg-amber-50 text-amber-600 ring-1 ring-amber-200 px-2.5 py-1 rounded-full">{{ count($onLeaveToday) }} orang</span>
        </div>
        <ul class="divide-y divide-gray-50">
            @foreach($onLeaveToday as $emp)
            <li class="flex items-center gap-4 px-6 py-4 hover:bg-gray-50/60 transition-colors">
                <img class="h-9 w-9 rounded-full flex-shrink-0 ring-2 ring-amber-100"
                     src="https://ui-avatars.com/api/?name={{ urlencode($emp['name']) }}&background=f59e0b&color=fff&bold=true&size=64"
                     alt="{{ $emp['name'] }}">
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-gray-900 truncate">{{ $emp['name'] }}</p>
                    <p class="text-xs text-gray-400 truncate">{{ $emp['role'] }} · {{ $emp['dept'] }}</p>
                </div>
                <span class="text-xs text-gray-400 whitespace-nowrap">s/d {{ $emp['until'] }}</span>
            </li>
            @endforeach
        </ul>
    </div>

    <!-- Karyawan Baru -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
            <h2 class="text-base font-semibold text-gray-900">Karyawan Baru Bulan Ini</h2>
            <span class="text-xs font-semibold bg-emerald-50 text-emerald-600 ring-1 ring-emerald-200 px-2.5 py-1 rounded-full">{{ count($newEmployees) }} orang</span>
        </div>
        <ul class="divide-y divide-gray-50">
            @foreach($newEmployees as $emp)
            <li class="flex items-center gap-4 px-6 py-4 hover:bg-gray-50/60 transition-colors">
                <img class="h-9 w-9 rounded-full flex-shrink-0 ring-2 ring-emerald-100"
                     src="https://ui-avatars.com/api/?name={{ urlencode($emp['name']) }}&background=10b981&color=fff&bold=true&size=64"
                     alt="{{ $emp['name'] }}">
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-gray-900 truncate">{{ $emp['name'] }}</p>
                    <p class="text-xs text-gray-400 truncate">{{ $emp['role'] }} · {{ $emp['dept'] }}</p>
                </div>
                <span class="text-xs text-gray-400 whitespace-nowrap">{{ $emp['joined'] }}</span>
            </li>
            @endforeach
        </ul>
    </div>
</div>

<!-- Upcoming Events Row -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    <!-- Ulang Tahun -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <div class="flex items-center gap-3 mb-5">
            <div class="p-2 rounded-xl bg-pink-50 text-pink-500">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a4 4 0 00-4-4H5.45a4 4 0 00-3.95 4.6L2.9 13H5m7-5h7.1a4 4 0 013.95 4.6L22.6 13H19m-7 0v8m-5 0h10"/>
                </svg>
            </div>
            <div>
                <h2 class="text-base font-semibold text-gray-900">Ulang Tahun Minggu Ini</h2>
                <p class="text-xs text-gray-400">Jangan lupa ucapkan selamat!</p>
            </div>
        </div>
        <ul class="space-y-3">
            @foreach($upcomingBirthdays as $b)
            <li class="flex items-center gap-3">
                <img class="h-8 w-8 rounded-full flex-shrink-0"
                     src="https://ui-avatars.com/api/?name={{ urlencode($b['name']) }}&background=ec4899&color=fff&bold=true&size=64"
                     alt="{{ $b['name'] }}">
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-gray-900 truncate">{{ $b['name'] }}</p>
                    <p class="text-xs text-gray-400">{{ $b['dept'] }}</p>
                </div>
                <span class="text-xs font-semibold text-pink-600 bg-pink-50 px-2.5 py-1 rounded-full">{{ $b['date'] }}</span>
            </li>
            @endforeach
        </ul>
    </div>

    <!-- Kontrak Habis -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <div class="flex items-center gap-3 mb-5">
            <div class="p-2 rounded-xl bg-red-50 text-red-500">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <div>
                <h2 class="text-base font-semibold text-gray-900">Kontrak Akan Habis</h2>
                <p class="text-xs text-gray-400">Perlu tindak lanjut segera</p>
            </div>
        </div>
        <ul class="space-y-3">
            @foreach($expiringContracts as $c)
            <li class="flex items-center gap-3">
                <img class="h-8 w-8 rounded-full flex-shrink-0"
                     src="https://ui-avatars.com/api/?name={{ urlencode($c['name']) }}&background=ef4444&color=fff&bold=true&size=64"
                     alt="{{ $c['name'] }}">
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-gray-900 truncate">{{ $c['name'] }}</p>
                    <p class="text-xs text-gray-400">{{ $c['role'] }}</p>
                </div>
                <span class="text-xs font-semibold text-red-600 bg-red-50 px-2.5 py-1 rounded-full">{{ $c['expires'] }}</span>
            </li>
            @endforeach
        </ul>
    </div>
</div>

@endsection
