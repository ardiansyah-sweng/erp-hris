@extends('layouts.app')

@section('title', 'Jadwal & Shift Kerja - ERP HRIS')

@section('content')
<div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div>
        <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Shift & Jadwal Kerja</h1>
        <p class="mt-1 text-sm text-gray-500">Kelola master shift dan penugasan shift ke karyawan.</p>
    </div>
    <div class="flex gap-2">
        <a href="{{ route('shifts.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium text-sm rounded-xl transition shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Shift
        </a>
    </div>
</div>

@if(session('success'))
<div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-sm font-medium">
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl text-sm font-medium">
    {{ session('error') }}
</div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <!-- Master Shift Table -->
    <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <h2 class="text-base font-semibold text-gray-900">Daftar Master Shift</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50 text-xs font-semibold text-gray-500 uppercase">
                        <th class="px-6 py-3.5">Nama Shift</th>
                        <th class="px-6 py-3.5">Jam Kerja</th>
                        <th class="px-6 py-3.5">Total Jam</th>
                        <th class="px-6 py-3.5">Status</th>
                        <th class="px-6 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 text-sm">
                    @forelse($shifts as $shift)
                    <tr class="hover:bg-gray-50/60 transition-colors">
                        <td class="px-6 py-4 font-semibold text-gray-900">{{ $shift->name }}</td>
                        <td class="px-6 py-4 font-medium text-gray-600">{{ $shift->start_time }} - {{ $shift->end_time }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $shift->total_hours }} Jam</td>
                        <td class="px-6 py-4">
                            @if($shift->is_active)
                                <span class="px-2.5 py-1 text-xs font-semibold text-emerald-700 bg-emerald-50 rounded-full">Aktif</span>
                            @else
                                <span class="px-2.5 py-1 text-xs font-semibold text-gray-600 bg-gray-100 rounded-full">Nonaktif</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right flex justify-end gap-2">
                            <a href="{{ route('shifts.edit', $shift->id) }}" class="text-indigo-600 hover:text-indigo-900 font-medium text-xs">Edit</a>
                            <form action="{{ route('shifts.destroy', $shift->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus shift ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 font-medium text-xs">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-400">Belum ada master shift. Silakan tambah master shift baru.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Form Assign Shift ke Karyawan -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <h2 class="text-base font-semibold text-gray-900 mb-4">Assign Shift ke Karyawan</h2>
        <form action="{{ route('shifts.assign.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1">Karyawan</label>
                <select name="employee_id" required class="w-full rounded-xl border-gray-200 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">-- Pilih Karyawan --</option>
                    @foreach($employees as $emp)
                        <option value="{{ $emp->id }}">{{ $emp->name }} ({{ $emp->employee_code }})</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1">Pilih Shift</label>
                <select name="shift_id" required class="w-full rounded-xl border-gray-200 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">-- Pilih Shift --</option>
                    @foreach($shifts as $s)
                        <option value="{{ $s->id }}">{{ $s->name }} ({{ $s->start_time }} - {{ $s->end_time }})</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1">Tanggal Mulai Berlaku</label>
                <input type="date" name="effective_date" required value="{{ date('Y-m-d') }}" class="w-full rounded-xl border-gray-200 text-sm focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1">Tanggal Selesai (Opsional)</label>
                <input type="date" name="end_date" class="w-full rounded-xl border-gray-200 text-sm focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <button type="submit" class="w-full py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium text-sm rounded-xl transition shadow-sm">
                Simpan Assignment
            </button>
        </form>
    </div>

</div>

<!-- Assignments Table -->
<div class="mt-8 bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100">
        <h2 class="text-base font-semibold text-gray-900">Riwayat Penugasan Shift Karyawan</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50/50 text-xs font-semibold text-gray-500 uppercase">
                    <th class="px-6 py-3.5">Karyawan</th>
                    <th class="px-6 py-3.5">Shift Assigned</th>
                    <th class="px-6 py-3.5">Berlaku Dari</th>
                    <th class="px-6 py-3.5">Sampai Tanggal</th>
                    <th class="px-6 py-3.5 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50 text-sm">
                @forelse($assignments as $assign)
                <tr class="hover:bg-gray-50/60 transition-colors">
                    <td class="px-6 py-4 font-semibold text-gray-900">{{ $assign->employee->name ?? '-' }}</td>
                    <td class="px-6 py-4 font-medium text-indigo-600">{{ $assign->shift->name ?? '-' }} ({{ $assign->shift->start_time ?? '' }} - {{ $assign->shift->end_time ?? '' }})</td>
                    <td class="px-6 py-4 text-gray-600">{{ $assign->effective_date->format('d M Y') }}</td>
                    <td class="px-6 py-4 text-gray-600">{{ $assign->end_date ? $assign->end_date->format('d M Y') : 'Sekarang (Aktif)' }}</td>
                    <td class="px-6 py-4 text-right">
                        <form action="{{ route('shifts.assign.destroy', $assign->id) }}" method="POST" onsubmit="return confirm('Hapus assignment ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900 font-medium text-xs">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-gray-400">Belum ada penugasan shift ke karyawan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
