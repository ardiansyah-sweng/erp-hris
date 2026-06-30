@extends('layouts.app')

@section('title', 'Detail Absensi - ERP HRIS')

@section('content')

@php
    $statusBadges = [
        'present' => ['Hadir', 'bg-emerald-50 text-emerald-700 ring-emerald-600/20', 'bg-emerald-500'],
        'late'    => ['Terlambat', 'bg-amber-50 text-amber-700 ring-amber-600/20', 'bg-amber-500'],
        'absent'  => ['Tidak Hadir', 'bg-red-50 text-red-700 ring-red-600/20', 'bg-red-500'],
        'sick'    => ['Sakit', 'bg-blue-50 text-blue-700 ring-blue-600/20', 'bg-blue-500'],
        'leave'   => ['Cuti', 'bg-indigo-50 text-indigo-700 ring-indigo-600/20', 'bg-indigo-500'],
    ];
    [$statusLabel, $statusClass, $statusDot] = $statusBadges[$attendance->status]
        ?? [$attendance->status, 'bg-gray-50 text-gray-700 ring-gray-600/20', 'bg-gray-500'];
@endphp

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

    <!-- Header -->
    <div class="flex items-start justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">
                Detail Absensi
            </h1>

            <p class="mt-2 text-sm text-gray-500">
                Informasi lengkap absensi karyawan.
            </p>
        </div>

        <a href="{{ route('absensi.index') }}"
           class="rounded-xl border border-gray-200 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50 transition">
            ← Kembali
        </a>
    </div>

    <!-- Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

        <!-- Header Card -->
        <div class="px-6 py-6 border-b border-gray-100">
            <h2 class="text-2xl font-bold text-gray-900">
                {{ $attendance->employee->name ?? '-' }}
            </h2>

            <p class="text-gray-500 mt-1">
                {{ $attendance->employee->jobrole->role ?? '-' }}
            </p>
        </div>

        <!-- Detail -->
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-8">

            <div>
                <p class="text-xs uppercase tracking-wider text-gray-400 font-semibold">
                    Nama Karyawan
                </p>

                <p class="mt-2 font-semibold text-gray-900">
                    {{ $attendance->employee->name ?? '-' }}
                </p>
            </div>

            <div>
                <p class="text-xs uppercase tracking-wider text-gray-400 font-semibold">
                    Jabatan
                </p>

                <p class="mt-2 font-semibold text-gray-900">
                    {{ $attendance->employee->jobrole->role ?? '-' }}
                </p>
            </div>

            <div>
                <p class="text-xs uppercase tracking-wider text-gray-400 font-semibold">
                    Tanggal
                </p>

                <p class="mt-2 font-semibold text-gray-900">
                    {{ $attendance->date?->format('d F Y') ?? '-' }}
                </p>
            </div>

            <div>
                <p class="text-xs uppercase tracking-wider text-gray-400 font-semibold">
                    Status
                </p>

                <div class="mt-2">
                    <span class="inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-sm font-semibold ring-1 ring-inset {{ $statusClass }}">
                        <span class="h-2 w-2 rounded-full {{ $statusDot }}"></span>
                        {{ $statusLabel }}
                    </span>
                </div>
            </div>

            <div>
                <p class="text-xs uppercase tracking-wider text-gray-400 font-semibold">
                    Jam Masuk
                </p>

                <p class="mt-2 font-semibold text-gray-900">
                    {{ $attendance->check_in ? substr($attendance->check_in, 0, 5) : '-' }}
                </p>
            </div>

            <div>
                <p class="text-xs uppercase tracking-wider text-gray-400 font-semibold">
                    Jam Keluar
                </p>

                <p class="mt-2 font-semibold text-gray-900">
                    {{ $attendance->check_out ? substr($attendance->check_out, 0, 5) : '-' }}
                </p>
            </div>

        </div>

    </div>

</div>

@endsection