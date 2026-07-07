@extends('layouts.app')

@section('title', 'Rekap Absensi - ERP HRIS')

@section('content')

    <!-- Header -->
    <div class="sm:flex sm:items-center sm:justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Rekap Presensi per Periode</h1>
            <p class="mt-1 text-sm text-gray-500">Ringkasan kehadiran karyawan berdasarkan rentang tanggal.</p>
        </div>
        <div class="mt-4 sm:mt-0 flex gap-3">
            <a href="{{ route('attendance.recap.pdf', ['start_date' => $startDate, 'end_date' => $endDate]) }}"
                class="inline-flex items-center justify-center rounded-xl bg-emerald-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-emerald-700 transition-all">
                Cetak PDF
            </a>
            <a href="{{ route('attendance.index') }}"
                class="inline-flex items-center justify-center rounded-xl bg-gray-100 px-5 py-2.5 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-200 transition-all">
                Kembali
            </a>
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
