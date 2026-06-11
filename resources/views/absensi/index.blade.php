@extends('layouts.app')

@section('title', 'Absensi - ERP HRIS')

@section('content')

@php
    $dummyAbsensi = [
        ['id' => 1, 'name' => 'Budi Santoso', 'role' => 'Software Engineer', 'date' => '2026-06-03', 'check_in' => '08:00', 'check_out' => '17:00', 'status' => 'Hadir'],
        ['id' => 2, 'name' => 'Siti Rahayu', 'role' => 'Data Analyst', 'date' => '2026-06-03', 'check_in' => '08:15', 'check_out' => '17:10', 'status' => 'Hadir'],
        ['id' => 3, 'name' => 'Ahmad Fauzi', 'role' => 'HR Manager', 'date' => '2026-06-03', 'check_in' => '-', 'check_out' => '-', 'status' => 'Tidak Hadir'],
        ['id' => 4, 'name' => 'Dewi Lestari', 'role' => 'Quality Assurance', 'date' => '2026-06-03', 'check_in' => '08:30', 'check_out' => '17:00', 'status' => 'Terlambat'],
        ['id' => 5, 'name' => 'Rizki Pratama', 'role' => 'Product Manager', 'date' => '2026-06-03', 'check_in' => '08:05', 'check_out' => '17:00', 'status' => 'Hadir'],
    ];
@endphp

    <!-- Header -->
    <div class="sm:flex sm:items-center sm:justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Manajemen Absensi</h1>
            <p class="mt-1 text-sm text-gray-500">Kelola dan pantau kehadiran karyawan perusahaan.</p>
        </div>
    </div>

    <!-- Stat Cards -->
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4 mb-8">
        <div class="bg-white overflow-hidden rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col transition-transform hover:-translate-y-1 duration-300">
            <div class="flex items-center mb-2">
                <div class="p-2.5 rounded-xl bg-emerald-50 text-emerald-600 mr-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <p class="text-sm font-medium text-gray-500">Hadir Hari Ini</p>
            </div>
            <div class="flex items-baseline gap-2">
                <p class="text-3xl font-bold text-gray-900">3</p>
                <span class="text-sm text-emerald-600 font-medium">karyawan</span>
            </div>
        </div>

        <div class="bg-white overflow-hidden rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col transition-transform hover:-translate-y-1 duration-300">
            <div class="flex items-center mb-2">
                <div class="p-2.5 rounded-xl bg-red-50 text-red-600 mr-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <p class="text-sm font-medium text-gray-500">Tidak Hadir</p>
            </div>
            <div class="flex items-baseline gap-2">
                <p class="text-3xl font-bold text-gray-900">1</p>
                <span class="text-sm text-red-600 font-medium">karyawan</span>
            </div>
        </div>

        <div class="bg-white overflow-hidden rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col transition-transform hover:-translate-y-1 duration-300">
            <div class="flex items-center mb-2">
                <div class="p-2.5 rounded-xl bg-amber-50 text-amber-600 mr-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <p class="text-sm font-medium text-gray-500">Terlambat</p>
            </div>
            <div class="flex items-baseline gap-2">
                <p class="text-3xl font-bold text-gray-900">1</p>
                <span class="text-sm text-amber-600 font-medium">karyawan</span>
            </div>
        </div>

        <div class="bg-white overflow-hidden rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col transition-transform hover:-translate-y-1 duration-300">
            <div class="flex items-center mb-2">
                <div class="p-2.5 rounded-xl bg-indigo-50 text-indigo-600 mr-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <p class="text-sm font-medium text-gray-500">Total Karyawan</p>
            </div>
            <div class="flex items-baseline gap-2">
                <p class="text-3xl font-bold text-gray-900">5</p>
                <span class="text-sm text-indigo-600 font-medium">karyawan</span>
            </div>
        </div>
    </div>

    <!-- Tabel -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow duration-300">
        <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center">
    <h3 class="text-base font-semibold text-gray-900">
        Daftar Absensi Hari Ini
    </h3>

    <div class="flex items-center gap-3">

        <a href="{{ route('absensi.create') }}"
           class="inline-flex items-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700 transition">
            + Tambah Absensi
        </a>

        <div class="relative">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>

            <input type="text"
                   class="block w-full rounded-xl border-0 py-2 pl-10 pr-3 text-gray-900 ring-1 ring-inset ring-gray-200 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm bg-gray-50/50"
                   placeholder="Cari karyawan...">
        </div>

    </div>
</div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50/50">
                    <tr>
                        <th class="py-4 pl-6 pr-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-widest">No</th>
                        <th class="px-3 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-widest">Nama Karyawan</th>
                        <th class="px-3 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-widest">Jabatan</th>
                        <th class="px-3 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-widest">Tanggal</th>
                        <th class="px-3 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-widest">Jam Masuk</th>
                        <th class="px-3 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-widest">Jam Keluar</th>
                        <th class="px-3 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-widest">Status</th>
                        <th class="px-3 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-widest">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @forelse($dummyAbsensi as $absen)
                        <tr class="hover:bg-indigo-50/40 transition-colors duration-150 group">
                            <td class="whitespace-nowrap py-4 pl-6 pr-3 text-sm font-medium text-gray-900">{{ $loop->iteration }}</td>
                            <td class="whitespace-nowrap px-3 py-4">
                                <div class="text-sm font-semibold text-gray-900 group-hover:text-indigo-600 transition-colors">{{ $absen['name'] }}</div>
                            </td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-600">{{ $absen['role'] }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-600">{{ $absen['date'] }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-600">{{ $absen['check_in'] }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-600">{{ $absen['check_out'] }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm">
    @if($absen['status'] == 'Hadir')
        <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700 ring-1 ring-inset ring-emerald-600/20">
            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
            Hadir
        </span>
    @elseif($absen['status'] == 'Terlambat')
        <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-50 px-2.5 py-1 text-xs font-semibold text-amber-700 ring-1 ring-inset ring-amber-600/20">
            <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>
            Terlambat
        </span>
    @else
        <span class="inline-flex items-center gap-1.5 rounded-full bg-red-50 px-2.5 py-1 text-xs font-semibold text-red-700 ring-1 ring-inset ring-red-600/20">
            <span class="h-1.5 w-1.5 rounded-full bg-red-500"></span>
            Tidak Hadir
        </span>
    @endif
</td>

<td class="whitespace-nowrap px-3 py-4 text-sm">
    <a href="{{ route('absensi.detail') }}"
       class="inline-flex items-center rounded-lg bg-indigo-50 px-3 py-2 text-xs font-semibold text-indigo-600 hover:bg-indigo-100 transition">
        Detail
    </a>
</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-16 text-center">
                                <h3 class="text-sm font-semibold text-gray-900">Belum ada data absensi</h3>
                                <p class="mt-1 text-sm text-gray-500">Data absensi hari ini belum tersedia.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection