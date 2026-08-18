@extends('layouts.app')

@section('title', 'Portal Karyawan (Self-Service) - ERP HRIS')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Portal Karyawan (Self-Service)</h1>
    <p class="mt-1 text-sm text-gray-500">Selamat datang, {{ $data['employee']->name }}! Berikut informasi ringkasan jadwal, lembur, dan klaim Anda.</p>
</div>

<!-- Stat Grid -->
<div class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-4 mb-8">

    <!-- Shift Hari Ini -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <div class="flex items-center justify-between">
            <p class="text-sm font-medium text-gray-500">Shift Kerja Anda</p>
            <div class="p-2.5 rounded-xl bg-indigo-50 text-indigo-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
        <div class="mt-3">
            <span class="text-xl font-bold text-gray-900 block">{{ $data['current_shift']->name ?? 'Shift Normal' }}</span>
            <span class="text-xs text-indigo-600 font-medium">{{ $data['current_shift']->start_time ?? '08:00' }} - {{ $data['current_shift']->end_time ?? '17:00' }}</span>
        </div>
    </div>

    <!-- Sisa Jatah Cuti -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <div class="flex items-center justify-between">
            <p class="text-sm font-medium text-gray-500">Sisa Jatah Cuti</p>
            <div class="p-2.5 rounded-xl bg-amber-50 text-amber-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
        </div>
        <div class="mt-3">
            <span class="text-3xl font-bold text-gray-900">{{ $data['remaining_leave'] }}</span>
            <span class="text-xs text-gray-500 font-medium ml-1">Hari (Tahun Ini)</span>
        </div>
    </div>

    <!-- Total Lembur Bulan Ini -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <div class="flex items-center justify-between">
            <p class="text-sm font-medium text-gray-500">Lembur Bulan Ini</p>
            <div class="p-2.5 rounded-xl bg-emerald-50 text-emerald-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
        <div class="mt-3">
            <span class="text-3xl font-bold text-gray-900">{{ $data['overtime_hours_month'] }}</span>
            <span class="text-xs text-emerald-600 font-medium ml-1">Jam (Rp {{ number_format($data['overtime_pay_month'], 0, ',', '.') }})</span>
        </div>
    </div>

    <!-- Reimbursement Pending -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <div class="flex items-center justify-between">
            <p class="text-sm font-medium text-gray-500">Klaim Pending</p>
            <div class="p-2.5 rounded-xl bg-blue-50 text-blue-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </div>
        </div>
        <div class="mt-3">
            <span class="text-3xl font-bold text-gray-900">{{ $data['pending_reimbursements'] }}</span>
            <span class="text-xs text-gray-500 font-medium ml-1">Pengajuan Pending</span>
        </div>
    </div>

</div>

<!-- Quick Action Shortcuts -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
    <a href="{{ route('self-service.schedule') }}" class="p-4 bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition flex items-center gap-3">
        <div class="p-3 bg-indigo-50 text-indigo-600 rounded-xl">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
        </div>
        <div>
            <h3 class="font-semibold text-gray-900 text-sm">Lihat Jadwal Shift</h3>
            <p class="text-xs text-gray-400">Jadwal kerja sebulan</p>
        </div>
    </a>

    <a href="{{ route('self-service.overtime') }}" class="p-4 bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition flex items-center gap-3">
        <div class="p-3 bg-emerald-50 text-emerald-600 rounded-xl">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div>
            <h3 class="font-semibold text-gray-900 text-sm">Ajukan Lembur</h3>
            <p class="text-xs text-gray-400">Form pengajuan lembur</p>
        </div>
    </a>

    <a href="{{ route('self-service.reimbursement') }}" class="p-4 bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition flex items-center gap-3">
        <div class="p-3 bg-blue-50 text-blue-600 rounded-xl">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
        </div>
        <div>
            <h3 class="font-semibold text-gray-900 text-sm">Ajukan Reimbursement</h3>
            <p class="text-xs text-gray-400">Klaim biaya & upload nota</p>
        </div>
    </a>

    <a href="{{ route('self-service.payslip') }}" class="p-4 bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition flex items-center gap-3">
        <div class="p-3 bg-amber-50 text-amber-600 rounded-xl">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
        </div>
        <div>
            <h3 class="font-semibold text-gray-900 text-sm">Lihat Slip Gaji</h3>
            <p class="text-xs text-gray-400">Download slip gaji PDF</p>
        </div>
    </a>
</div>
@endsection
