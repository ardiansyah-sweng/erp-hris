@extends('layouts.app')

@section('title', 'Detail Slip Gaji - ERP HRIS')

@section('content')

@php
    $namaBulan = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                  'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
@endphp

<div class="space-y-6">

    <!-- Header -->
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Detail Slip Gaji</h1>
            <p class="mt-1 text-sm text-gray-500">
                Rincian lengkap penggajian karyawan untuk periode terkait.
            </p>
        </div>

        <div class="flex items-center gap-3 mt-4 sm:mt-0">
            <a href="{{ route('payroll.pdf', $payroll->id) }}"
               class="inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-indigo-700 transition-colors shadow-sm">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Download PDF
            </a>
            <a href="{{ route('payroll.index') }}"
               class="inline-flex items-center gap-2 rounded-xl border border-gray-300 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50 transition-colors">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali
            </a>
        </div>
    </div>

    <!-- Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

        <!-- Card header: identitas karyawan & periode -->
        <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between gap-4 flex-wrap">
            <div class="flex items-center gap-4">
                <img class="h-12 w-12 rounded-full ring-2 ring-indigo-100 object-cover"
                     src="https://ui-avatars.com/api/?name={{ urlencode($payroll->employee->name) }}&background=4f46e5&color=fff&bold=true"
                     alt="{{ $payroll->employee->name }}">
                <div>
                    <h3 class="text-base font-semibold text-gray-900">{{ $payroll->employee->name }}</h3>
                    <p class="text-sm text-gray-500">{{ $payroll->employee->jobrole->role ?? '-' }}</p>
                </div>
            </div>

            <div class="text-right">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-widest">Periode</p>
                <p class="text-sm font-medium text-gray-900">
                    {{ $namaBulan[$payroll->month] ?? $payroll->month }} {{ $payroll->year }}
                </p>
            </div>
        </div>

        <!-- Status -->
        <div class="px-6 pt-5">
            <dt class="text-sm text-gray-500 mb-1">Status Pembayaran</dt>
            <dd>
                @if($payroll->status == 'paid')
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700 ring-1 ring-inset ring-emerald-600/20">
                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                        Paid
                    </span>
                @else
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-50 px-2.5 py-1 text-xs font-semibold text-amber-700 ring-1 ring-inset ring-amber-600/20">
                        <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>
                        Pending
                    </span>
                @endif
            </dd>
        </div>

        <!-- Rincian gaji -->
        <div class="p-6">
            <dl class="divide-y divide-gray-100">
                <div class="flex items-center justify-between py-3">
                    <dt class="text-sm text-gray-600">Gaji Pokok</dt>
                    <dd class="text-sm font-medium text-gray-900">
                        Rp {{ number_format($payroll->basic_salary, 0, ',', '.') }}
                    </dd>
                </div>
                <div class="flex items-center justify-between py-3">
                    <dt class="text-sm text-gray-600">Tunjangan</dt>
                    <dd class="text-sm font-medium text-emerald-600">
                        + Rp {{ number_format($payroll->allowances, 0, ',', '.') }}
                    </dd>
                </div>
                <div class="flex items-center justify-between py-3">
                    <dt class="text-sm text-gray-600">Potongan</dt>
                    <dd class="text-sm font-medium text-rose-600">
                        - Rp {{ number_format($payroll->deductions, 0, ',', '.') }}
                    </dd>
                </div>
                <div class="flex items-center justify-between py-4 bg-indigo-50/40 -mx-6 px-6 mt-2">
                    <dt class="text-base font-semibold text-gray-900">Total Gaji Bersih</dt>
                    <dd class="text-lg font-bold text-indigo-600">
                        Rp {{ number_format($payroll->net_salary, 0, ',', '.') }}
                    </dd>
                </div>
            </dl>
        </div>
    </div>

</div>

@endsection
