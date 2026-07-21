@extends('layouts.app')

@section('title', 'Rekap Absensi - ERP HRIS')

@section('content')

    <!-- Header -->
    <div class="sm:flex sm:items-center sm:justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Rekap Presensi per Periode</h1>
            <p class="mt-1 text-sm text-gray-500">Ringkasan kehadiran karyawan berdasarkan rentang tanggal.</p>
        </div>
    </div>

    <!-- Filter -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
        <form method="GET" action="{{ route('attendance.recap') }}" class="flex flex-wrap items-end gap-3">
            <div>
                <label class="block text-xs font-medium text-gray-500 mb-1">Dari Tanggal</label>
                <input type="date" name="start_date" value="{{ $startDate }}"
                    class="rounded-xl border-0 py-2 px-3 text-sm ring-1 ring-gray-200 focus:ring-2 focus:ring-indigo-600">
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-500 mb-1">Sampai Tanggal</label>
                <input type="date" name="end_date" value="{{ $endDate }}"
                    class="rounded-xl border-0 py-2 px-3 text-sm ring-1 ring-gray-200 focus:ring-2 focus:ring-indigo-600">
            </div>
            <button type="submit"
                class="rounded-xl bg-indigo-600 px-5 py-2 text-sm font-semibold text-white hover:bg-indigo-700">
                Tampilkan
            </button>
            <a href="{{ route('attendance.recap.export.preview', request()->query()) }}"
               target="_blank"
               class="rounded-xl bg-green-600 px-5 py-2 text-sm font-semibold text-white hover:bg-green-700 inline-flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Export PDF
            </a>
        </form>
    </div>

    <!-- Tabel Rekap -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100">
            <h3 class="text-base font-semibold text-gray-900">Rekap Kehadiran</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50/50">
                    <tr>
                        <th class="py-4 pl-6 pr-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-widest">
                            Karyawan</th>
                        <th class="px-3 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-widest">
                            Hadir</th>
                        <th class="px-3 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-widest">
                            Tidak Hadir</th>
                        <th class="px-3 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-widest">
                            Terlambat</th>
                        <th class="px-3 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-widest">
                            Sakit</th>
                        <th class="px-3 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-widest">Cuti
                        </th>
                        <th class="px-3 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-widest">
                            Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @forelse($recap as $r)
                        <tr class="hover:bg-indigo-50/40">
                            <td class="whitespace-nowrap py-4 pl-6 pr-3 text-sm font-semibold text-gray-900">
                                {{ $r['employee_name'] }}</td>
                            <td class="px-3 py-4 text-sm text-center text-gray-600">{{ $r['summary']['present'] }}</td>
                            <td class="px-3 py-4 text-sm text-center text-gray-600">{{ $r['summary']['absent'] }}</td>
                            <td class="px-3 py-4 text-sm text-center text-gray-600">{{ $r['summary']['late'] }}</td>
                            <td class="px-3 py-4 text-sm text-center text-gray-600">{{ $r['summary']['sick'] }}</td>
                            <td class="px-3 py-4 text-sm text-center text-gray-600">{{ $r['summary']['leave'] }}</td>
                            <td class="px-3 py-4 text-sm text-center font-semibold text-gray-900">{{ $r['total_records'] }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-10 text-center text-sm text-gray-500">Tidak ada data pada periode
                                ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection