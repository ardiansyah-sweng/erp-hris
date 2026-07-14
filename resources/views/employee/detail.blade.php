@extends('layouts.app')

@section('title', 'Detail Karyawan - ERP HRIS')

@section('content')
<div class="space-y-6">

    <!-- Header -->
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Detail Karyawan</h1>
            <p class="mt-1 text-sm text-gray-500">
                Informasi profil lengkap dan status kepegawaian karyawan.
            </p>
        </div>

        <div class="mt-4 sm:mt-0 flex items-center gap-3">
            <a href="{{ route('employees.edit', $employee->id) }}"
               class="inline-flex items-center gap-2 rounded-xl bg-amber-500 px-5 py-2.5 text-sm font-semibold text-white hover:bg-amber-600 transition-colors shadow-sm">
                ✏️ Edit Data
            </a>
            <a href="{{ route('employees.index') }}"
               class="inline-flex items-center gap-2 rounded-xl border border-gray-300 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50 transition-colors shadow-sm">
                <svg class="h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali ke Daftar
            </a>
        </div>
    </div>

    <!-- Main Profile Card & Details Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Left Side: Profile Summary Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col items-center text-center">
            <div class="flex h-24 w-24 items-center justify-center rounded-full bg-indigo-100 text-indigo-700 text-3xl font-extrabold shadow-inner mb-4">
                {{ strtoupper(substr($employee->name ?? '?', 0, 1)) }}
            </div>
            
            <h2 class="text-xl font-bold text-gray-900">{{ $employee->name ?? '-' }}</h2>
            <p class="text-sm font-medium text-indigo-600 mt-1">{{ $employee->jobrole->role ?? 'Staf / Belum Ditentukan' }}</p>
            
            <div class="mt-4">
                @if(($employee->status ?? 'active') === 'active')
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700 ring-1 ring-inset ring-emerald-600/20">
                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                        Aktif
                    </span>
                @else
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-red-50 px-3 py-1 text-xs font-semibold text-red-700 ring-1 ring-inset ring-red-600/20">
                        <span class="h-1.5 w-1.5 rounded-full bg-red-500"></span>
                        Non-Aktif
                    </span>
                @endif
            </div>

            <div class="w-full border-t border-gray-100 my-6"></div>

            <!-- Fast Contact / Details -->
            <div class="w-full space-y-4 text-left">
                <div class="flex items-center gap-3 text-sm text-gray-600">
                    <svg class="h-5 w-5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <span class="truncate">{{ $employee->email ?? '-' }}</span>
                </div>
                <div class="flex items-center gap-3 text-sm text-gray-600">
                    <svg class="h-5 w-5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                    <span>{{ $employee->phone_number ?? '-' }}</span>
                </div>
                <div class="flex items-center gap-3 text-sm text-gray-600">
                    <svg class="h-5 w-5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span class="line-clamp-2">{{ $employee->address ?? '-' }}</span>
                </div>
            </div>
        </div>

        <!-- Right Side: Details Tab/Information Section -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Personal Info Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-50 bg-gray-50/50">
                    <h3 class="text-base font-bold text-gray-900">Informasi Pribadi Karyawan</h3>
                </div>
                <div class="p-6">
                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4">
                        <div class="border-b border-gray-100 pb-3">
                            <dt class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Nomor Induk Kependudukan (NIK)</dt>
                            <dd class="text-sm font-semibold text-gray-800 mt-1">{{ $employee->id_number ?? '-' }}</dd>
                        </div>
                        <div class="border-b border-gray-100 pb-3">
                            <dt class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Usia</dt>
                            <dd class="text-sm font-semibold text-gray-800 mt-1">{{ $employee->age ?? '-' }} Tahun</dd>
                        </div>
                        <div class="border-b border-gray-100 pb-3 sm:border-0 sm:pb-0">
                            <dt class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Tempat Lahir</dt>
                            <dd class="text-sm font-semibold text-gray-800 mt-1">{{ $employee->place_of_birth ?? '-' }}</dd>
                        </div>
                        <div class="pb-3 sm:pb-0">
                            <dt class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Tanggal Lahir</dt>
                            <dd class="text-sm font-semibold text-gray-800 mt-1">
                                {{ $employee->date_of_birth ? \Carbon\Carbon::parse($employee->date_of_birth)->format('d F Y') : '-' }}
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Employment Details Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-50 bg-gray-50/50">
                    <h3 class="text-base font-bold text-gray-900">Informasi Pekerjaan & Sistem</h3>
                </div>
                <div class="p-6">
                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4">
                        <div class="border-b border-gray-100 pb-3">
                            <dt class="text-xs font-semibold text-gray-400 uppercase tracking-wider">ID Karyawan</dt>
                            <dd class="text-sm font-semibold text-gray-800 mt-1 font-mono text-xs">#{{ $employee->id ?? '-' }}</dd>
                        </div>
                        <div class="border-b border-gray-100 pb-3">
                            <dt class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Jabatan / Role</dt>
                            <dd class="text-sm font-semibold text-gray-800 mt-1">{{ $employee->jobrole->role ?? 'Staf / Belum Ditentukan' }}</dd>
                        </div>
                        <div class="border-b border-gray-100 pb-3 sm:border-0 sm:pb-0">
                            <dt class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Tanggal Dibuat</dt>
                            <dd class="text-sm font-semibold text-gray-800 mt-1">
                                {{ $employee->created_at ? \Carbon\Carbon::parse($employee->created_at)->format('d F Y H:i') : '-' }}
                            </dd>
                        </div>
                        <div class="pb-3 sm:pb-0">
                            <dt class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Terakhir Diperbarui</dt>
                            <dd class="text-sm font-semibold text-gray-800 mt-1">
                                {{ $employee->updated_at ? \Carbon\Carbon::parse($employee->updated_at)->format('d F Y H:i') : '-' }}
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection