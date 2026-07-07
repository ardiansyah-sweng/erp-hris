@extends('layouts.app')

@section('title', 'Absensi - ERP HRIS')

@section('content')

@php
    // Label status (DB) -> teks tampilan
    $statusLabels = [
        'present' => 'Hadir',
        'late'    => 'Terlambat',
        'absent'  => 'Tidak Hadir',
        'sick'    => 'Sakit',
        'leave'   => 'Cuti',
    ];

    // Ubah satu baris absensi menjadi array sederhana untuk modal/JSON
    $toCard = function ($absen) use ($statusLabels) {
        return [
            'name'      => $absen->employee->name ?? '-',
            'role'      => $absen->employee->jobrole->role ?? '-',
            'date'      => $absen->date?->format('d M Y') ?? '-',
            'check_in'  => $absen->check_in ? substr($absen->check_in, 0, 5) : '-',
            'check_out' => $absen->check_out ? substr($absen->check_out, 0, 5) : '-',
            'status'    => $statusLabels[$absen->status] ?? $absen->status,
        ];
    };

    $hadir        = $attendances->where('status', 'present')->map($toCard)->values();
    $tidakHadir   = $attendances->where('status', 'absent')->map($toCard)->values();
    $terlambat    = $attendances->where('status', 'late')->map($toCard)->values();
    $totalKaryawan = $attendances->map($toCard)->values();
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
        <div onclick="openAbsensiModal('hadir')" class="cursor-pointer bg-white overflow-hidden rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col transition-transform hover:-translate-y-1 duration-300">
            <div class="flex items-center mb-2">
                <div class="p-2.5 rounded-xl bg-emerald-50 text-emerald-600 mr-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <p class="text-sm font-medium text-gray-500">Hadir Hari Ini</p>
            </div>
            <div class="flex items-baseline gap-2">
                <p class="text-3xl font-bold text-gray-900">{{ $hadir->count() }}</p>
                <span class="text-sm text-emerald-600 font-medium">karyawan</span>
            </div>
        </div>

        <div onclick="openAbsensiModal('tidakHadir')" class="cursor-pointer bg-white overflow-hidden rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col transition-transform hover:-translate-y-1 duration-300">
            <div class="flex items-center mb-2">
                <div class="p-2.5 rounded-xl bg-red-50 text-red-600 mr-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <p class="text-sm font-medium text-gray-500">Tidak Hadir</p>
            </div>
            <div class="flex items-baseline gap-2">
                <p class="text-3xl font-bold text-gray-900">{{ $tidakHadir->count() }}</p>
                <span class="text-sm text-red-600 font-medium">karyawan</span>
            </div>
        </div>

        <div onclick="openAbsensiModal('terlambat')" class="cursor-pointer bg-white overflow-hidden rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col transition-transform hover:-translate-y-1 duration-300">
            <div class="flex items-center mb-2">
                <div class="p-2.5 rounded-xl bg-amber-50 text-amber-600 mr-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <p class="text-sm font-medium text-gray-500">Terlambat</p>
            </div>
            <div class="flex items-baseline gap-2">
                <p class="text-3xl font-bold text-gray-900">{{ $terlambat->count() }}</p>
                <span class="text-sm text-amber-600 font-medium">karyawan</span>
            </div>
        </div>

        <div onclick="openAbsensiModal('total')" class="cursor-pointer bg-white overflow-hidden rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col transition-transform hover:-translate-y-1 duration-300">
            <div class="flex items-center mb-2">
                <div class="p-2.5 rounded-xl bg-indigo-50 text-indigo-600 mr-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <p class="text-sm font-medium text-gray-500">Total Karyawan</p>
            </div>
            <div class="flex items-baseline gap-2">
                <p class="text-3xl font-bold text-gray-900">{{ $totalKaryawan->count() }}</p>
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

        <form method="GET" action="{{ route('attendance.index') }}" class="flex items-center gap-2">
            <input type="date" name="date" value="{{ request('date') }}"
                   class="rounded-xl border-0 py-2 px-3 text-sm text-gray-900 ring-1 ring-inset ring-gray-200 focus:ring-2 focus:ring-inset focus:ring-indigo-600">

            <select name="status"
                    class="rounded-xl border-0 py-2 px-3 text-sm text-gray-900 ring-1 ring-inset ring-gray-200 focus:ring-2 focus:ring-inset focus:ring-indigo-600">
                <option value="">Semua Status</option>
                <option value="present" {{ request('status') === 'present' ? 'selected' : '' }}>Hadir</option>
                <option value="absent" {{ request('status') === 'absent' ? 'selected' : '' }}>Tidak Hadir</option>
                <option value="late" {{ request('status') === 'late' ? 'selected' : '' }}>Terlambat</option>
                <option value="sick" {{ request('status') === 'sick' ? 'selected' : '' }}>Sakit</option>
                <option value="leave" {{ request('status') === 'leave' ? 'selected' : '' }}>Cuti</option>
            </select>

            <button type="submit"
                    class="rounded-xl bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">
                Filter
            </button>

            @if(request('date') || request('status'))
                <a href="{{ route('attendance.index') }}" class="text-sm text-gray-500 hover:text-gray-700 underline">
                    Reset
                </a>
            @endif
        </form>

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
                    @forelse($attendances as $absen)
                        <tr class="hover:bg-indigo-50/40 transition-colors duration-150 group">
                            <td class="whitespace-nowrap py-4 pl-6 pr-3 text-sm font-medium text-gray-900">{{ $loop->iteration }}</td>
                            <td class="whitespace-nowrap px-3 py-4">
                                <div class="text-sm font-semibold text-gray-900 group-hover:text-indigo-600 transition-colors">{{ $absen->employee->name ?? '-' }}</div>
                            </td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-600">{{ $absen->employee->jobrole->role ?? '-' }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-600">{{ $absen->date?->format('d M Y') ?? '-' }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-600">{{ $absen->check_in ? substr($absen->check_in, 0, 5) : '-' }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-600">{{ $absen->check_out ? substr($absen->check_out, 0, 5) : '-' }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm">
    @if($absen->status === 'present')
        <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700 ring-1 ring-inset ring-emerald-600/20">
            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
            Hadir
        </span>
    @elseif($absen->status === 'late')
        <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-50 px-2.5 py-1 text-xs font-semibold text-amber-700 ring-1 ring-inset ring-amber-600/20">
            <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>
            Terlambat
        </span>
    @elseif($absen->status === 'sick')
        <span class="inline-flex items-center gap-1.5 rounded-full bg-blue-50 px-2.5 py-1 text-xs font-semibold text-blue-700 ring-1 ring-inset ring-blue-600/20">
            <span class="h-1.5 w-1.5 rounded-full bg-blue-500"></span>
            Sakit
        </span>
    @elseif($absen->status === 'leave')
        <span class="inline-flex items-center gap-1.5 rounded-full bg-indigo-50 px-2.5 py-1 text-xs font-semibold text-indigo-700 ring-1 ring-inset ring-indigo-600/20">
            <span class="h-1.5 w-1.5 rounded-full bg-indigo-500"></span>
            Cuti
        </span>
    @else
        <span class="inline-flex items-center gap-1.5 rounded-full bg-red-50 px-2.5 py-1 text-xs font-semibold text-red-700 ring-1 ring-inset ring-red-600/20">
            <span class="h-1.5 w-1.5 rounded-full bg-red-500"></span>
            Tidak Hadir
        </span>
    @endif
</td>

<td class="whitespace-nowrap px-3 py-4 text-sm">
    <a href="{{ route('attendance.detail', $absen->id) }}"
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

<!-- Modal -->
<div id="absensiModal" class="fixed inset-0 z-50 hidden bg-black/40">
    <div class="absolute inset-y-0 right-0 w-full lg:w-[70%] bg-white shadow-2xl overflow-y-auto">

        <div class="sticky top-0 bg-white z-10 px-8 py-6 border-b flex justify-between items-center">
            <div>
                <h3 id="modalTitle" class="text-2xl font-bold text-gray-900">Daftar Karyawan</h3>
                <p id="modalSubtitle" class="text-sm text-gray-500 mt-1">Informasi absensi hari ini</p>
            </div>

            <button onclick="closeAbsensiModal()"
                    class="px-4 py-2 rounded-xl bg-red-50 text-red-600 hover:bg-red-100 font-semibold">
                Tutup
            </button>
        </div>

        <div id="modalContent" class="p-8 grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5"></div>

    </div>
</div>

<script>
const absensiData = {
    hadir: @json($hadir),
    tidakHadir: @json($tidakHadir),
    terlambat: @json($terlambat),
    total: @json($totalKaryawan),
};

const modalTitles = {
    hadir: 'Karyawan Hadir Hari Ini',
    tidakHadir: 'Karyawan Tidak Hadir',
    terlambat: 'Karyawan Terlambat',
    total: 'Total Seluruh Karyawan',
};

const statusStyle = {
    Hadir: 'bg-emerald-50 text-emerald-700 ring-emerald-600/20',
    'Tidak Hadir': 'bg-red-50 text-red-700 ring-red-600/20',
    Terlambat: 'bg-amber-50 text-amber-700 ring-amber-600/20',
    Sakit: 'bg-blue-50 text-blue-700 ring-blue-600/20',
    Cuti: 'bg-indigo-50 text-indigo-700 ring-indigo-600/20',
};

function openAbsensiModal(type) {
    const modal = document.getElementById('absensiModal');
    const title = document.getElementById('modalTitle');
    const subtitle = document.getElementById('modalSubtitle');
    const content = document.getElementById('modalContent');

    title.innerText = modalTitles[type];
    subtitle.innerText = `${absensiData[type].length} karyawan ditemukan`;
    content.innerHTML = '';

    absensiData[type].forEach((item) => {
        const initials = item.name
            .split(' ')
            .map(word => word[0])
            .join('')
            .substring(0, 2)
            .toUpperCase();

        content.innerHTML += `
            <div class="bg-white border border-gray-100 rounded-2xl p-5 shadow-sm hover:shadow-md transition">
                <div class="flex items-start justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold">
                            ${initials}
                        </div>

                        <div>
                            <p class="font-bold text-gray-900">${item.name}</p>
                            <p class="text-sm text-gray-500">${item.role}</p>
                        </div>
                    </div>

                    <span class="text-xs font-semibold px-3 py-1 rounded-full ring-1 ${statusStyle[item.status]}">
                        ${item.status}
                    </span>
                </div>

                <div class="grid grid-cols-3 gap-3 mt-5 text-xs">
                    <div class="bg-gray-50 rounded-xl p-3">
                        <p class="text-gray-400">Tanggal</p>
                        <p class="font-semibold text-gray-700 mt-1">${item.date}</p>
                    </div>

                    <div class="bg-gray-50 rounded-xl p-3">
                        <p class="text-gray-400">Masuk</p>
                        <p class="font-semibold text-gray-700 mt-1">${item.check_in}</p>
                    </div>

                    <div class="bg-gray-50 rounded-xl p-3">
                        <p class="text-gray-400">Keluar</p>
                        <p class="font-semibold text-gray-700 mt-1">${item.check_out}</p>
                    </div>
                </div>
            </div>
        `;
    });

    modal.classList.remove('hidden');
}

function closeAbsensiModal() {
    document.getElementById('absensiModal').classList.add('hidden');
}
</script>

@endsection