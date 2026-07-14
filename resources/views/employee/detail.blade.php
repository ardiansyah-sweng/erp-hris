@extends('layouts.app')

@section('title', 'Detail Karyawan - ' . $employee->name)

@section('content')
<div class="flex-1 overflow-auto">
    <div class="p-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Detail Karyawan</h1>
                    <p class="text-gray-600 mt-1">Informasi lengkap karyawan</p>
                </div>
                <a href="/employees" class="inline-flex items-center gap-2 px-4 py-2.5 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors font-medium">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Kembali
                </a>
            </div>
        </div>

        <!-- Content -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-8">
                <!-- Profile Section -->
                <div class="mb-8 pb-8 border-b border-gray-100">
                    <div class="flex items-start gap-6">
                        <div class="flex-shrink-0">
                            <div class="w-20 h-20 rounded-lg bg-indigo-100 flex items-center justify-center">
                                <svg class="w-10 h-10 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1">
                            <h2 class="text-2xl font-bold text-gray-900">{{ $employee->name }}</h2>
                            <p class="text-gray-600 mt-1">{{ $employee->email }}</p>
                            @if($employee->jobrole)
                            <span class="inline-flex items-center px-3 py-1 mt-3 rounded-full text-sm font-medium bg-indigo-50 text-indigo-700">
                                {{ $employee->jobrole->role }}
                            </span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Information Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Left Column -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-6">Informasi Pribadi</h3>
                        
                        <div class="space-y-5">
                            <!-- ID -->
                            <div>
                                <label class="block text-sm font-medium text-gray-600 mb-1">ID</label>
                                <p class="text-base text-gray-900 font-medium">{{ $employee->id }}</p>
                            </div>

                            <!-- Nama -->
                            <div>
                                <label class="block text-sm font-medium text-gray-600 mb-1">Nama Lengkap</label>
                                <p class="text-base text-gray-900 font-medium">{{ $employee->name }}</p>
                            </div>

                            <!-- Email -->
                            <div>
                                <label class="block text-sm font-medium text-gray-600 mb-1">Email</label>
                                <p class="text-base text-gray-900 font-medium break-all">{{ $employee->email }}</p>
                            </div>

                            <!-- Nomor Telepon -->
                            <div>
                                <label class="block text-sm font-medium text-gray-600 mb-1">Nomor Telepon</label>
                                <p class="text-base text-gray-900 font-medium">{{ $employee->phone_number }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-6">Data Kelahiran & Identitas</h3>
                        
                        <div class="space-y-5">
                            <!-- Tempat Lahir -->
                            <div>
                                <label class="block text-sm font-medium text-gray-600 mb-1">Tempat Lahir</label>
                                <p class="text-base text-gray-900 font-medium">{{ $employee->place_of_birth }}</p>
                            </div>

                            <!-- Tanggal Lahir -->
                            <div>
                                <label class="block text-sm font-medium text-gray-600 mb-1">Tanggal Lahir</label>
                                <p class="text-base text-gray-900 font-medium">
                                    {{ $employee->date_of_birth ? $employee->date_of_birth->format('d-m-Y') : '-' }}
                                </p>
                            </div>

                            <!-- Usia -->
                            <div>
                                <label class="block text-sm font-medium text-gray-600 mb-1">Usia</label>
                                <p class="text-base text-gray-900 font-medium">{{ $employee->age }} tahun</p>
                            </div>

                            <!-- NIK -->
                            <div>
                                <label class="block text-sm font-medium text-gray-600 mb-1">NIK/KTP</label>
                                <p class="text-base text-gray-900 font-medium">{{ $employee->id_number }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Address Section -->
                <div class="mt-8 pt-8 border-t border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Alamat</h3>
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Alamat Tinggal</label>
                        <p class="text-base text-gray-900 font-medium leading-relaxed">{{ $employee->address }}</p>
                    </div>
                </div>

                <!-- Job Role Section -->
                <div class="mt-8 pt-8 border-t border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Informasi Pekerjaan</h3>
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Job Role</label>
                        @if($employee->jobrole)
                        <span class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-medium bg-indigo-50 text-indigo-700 border border-indigo-200">
                            {{ $employee->jobrole->role }}
                        </span>
                        @else
                        <p class="text-base text-gray-600">-</p>
                        @endif
                    </div>
                </div>

                <!-- Timestamps -->
                <div class="mt-8 pt-8 border-t border-gray-100">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">Dibuat Pada</label>
                            <p class="text-base text-gray-900">
                                {{ $employee->created_at ? $employee->created_at->format('d-m-Y H:i') : '-' }}
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">Diupdate Pada</label>
                            <p class="text-base text-gray-900">
                                {{ $employee->updated_at ? $employee->updated_at->format('d-m-Y H:i') : '-' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection