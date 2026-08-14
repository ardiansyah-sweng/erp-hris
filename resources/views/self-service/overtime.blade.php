@extends('layouts.app')

@section('title', 'Riwayat Lembur Saya - ERP HRIS')

@section('content')
<div class="mb-6">
    <a href="{{ route('self-service.dashboard') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-800">&larr; Kembali ke Portal</a>
    <h1 class="text-2xl font-bold text-gray-900 tracking-tight mt-2">Riwayat & Pengajuan Lembur Saya</h1>
    <p class="mt-1 text-sm text-gray-500">Lihat riwayat lembur Anda dan ajukan lembur baru.</p>
</div>

@if(session('success'))
<div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-sm font-medium">{{ session('success') }}</div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <!-- Riwayat Lembur -->
    <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <h2 class="text-base font-semibold text-gray-900">Riwayat Lembur</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50 text-xs font-semibold text-gray-500 uppercase">
                        <th class="px-6 py-3.5">Tanggal</th>
                        <th class="px-6 py-3.5">Shift / Actual Out</th>
                        <th class="px-6 py-3.5">Durasi</th>
                        <th class="px-6 py-3.5">Estimasi Upah</th>
                        <th class="px-6 py-3.5">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 text-sm">
                    @forelse($overtimes as $ot)
                    <tr class="hover:bg-gray-50/60 transition-colors">
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $ot->date->format('d M Y') }}</td>
                        <td class="px-6 py-4 text-gray-600">
                            <span class="text-gray-400">{{ $ot->scheduled_out }}</span> →
                            <span class="font-semibold text-gray-800">{{ $ot->actual_out }}</span>
                        </td>
                        <td class="px-6 py-4 font-bold text-indigo-600">{{ $ot->overtime_hours }} Jam</td>
                        <td class="px-6 py-4 font-semibold text-emerald-600">Rp {{ number_format($ot->overtime_pay, 0, ',', '.') }}</td>
                        <td class="px-6 py-4">
                            @if($ot->status === 'approved')
                                <span class="px-2.5 py-1 text-xs font-semibold text-emerald-700 bg-emerald-50 rounded-full">Approved</span>
                            @elseif($ot->status === 'rejected')
                                <span class="px-2.5 py-1 text-xs font-semibold text-red-700 bg-red-50 rounded-full">Rejected</span>
                            @else
                                <span class="px-2.5 py-1 text-xs font-semibold text-amber-700 bg-amber-50 rounded-full">Pending</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-400">Anda belum memiliki data lembur.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Form Ajukan Lembur -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <h2 class="text-base font-semibold text-gray-900 mb-4">Ajukan Lembur Baru</h2>
        <form action="{{ route('self-service.overtime.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1">Tanggal Lembur</label>
                <input type="date" name="date" required value="{{ date('Y-m-d') }}" class="w-full rounded-xl border-gray-200 text-sm focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1">Shift</label>
                <select name="shift_id" class="w-full rounded-xl border-gray-200 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">-- Shift Aktif --</option>
                    @foreach($shifts as $s)
                        <option value="{{ $s->id }}">{{ $s->name }} ({{ $s->end_time }})</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1">Jam Keluar Shift (Scheduled)</label>
                <input type="time" name="scheduled_out" required value="17:00" class="w-full rounded-xl border-gray-200 text-sm focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1">Jam Keluar Aktual</label>
                <input type="time" name="actual_out" required class="w-full rounded-xl border-gray-200 text-sm focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1">Keterangan</label>
                <textarea name="notes" rows="2" class="w-full rounded-xl border-gray-200 text-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="Alasan lembur..."></textarea>
            </div>

            <button type="submit" class="w-full py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium text-sm rounded-xl transition shadow-sm">Kirim Pengajuan</button>
        </form>
    </div>

</div>
@endsection
