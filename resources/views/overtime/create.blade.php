@extends('layouts.app')

@section('title', 'Pengajuan Lembur Baru - ERP HRIS')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('overtime.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-800 flex items-center gap-1">
            &larr; Kembali ke Daftar Lembur
        </a>
        <h1 class="text-2xl font-bold text-gray-900 tracking-tight mt-2">Form Pengajuan Lembur</h1>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <form action="{{ route('overtime.store') }}" method="POST" class="space-y-5">
            @csrf
            <div>
                <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1">Pilih Karyawan</label>
                <select name="employee_id" required class="w-full rounded-xl border-gray-200 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">-- Pilih Karyawan --</option>
                    @foreach($employees as $emp)
                        <option value="{{ $emp->id }}">{{ $emp->name }} ({{ $emp->employee_code }})</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1">Tanggal Lembur</label>
                <input type="date" name="date" required value="{{ date('Y-m-d') }}" class="w-full rounded-xl border-gray-200 text-sm focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1">Shift Referensi (Opsional)</label>
                <select name="shift_id" class="w-full rounded-xl border-gray-200 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">-- Shift Aktif Karyawan / Default --</option>
                    @foreach($shifts as $s)
                        <option value="{{ $s->id }}">{{ $s->name }} (Keluar Shift: {{ $s->end_time }})</option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1">Jam Keluar Shift (Scheduled)</label>
                    <input type="time" name="scheduled_out" required value="17:00" class="w-full rounded-xl border-gray-200 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1">Jam Keluar Aktual (Actual Out)</label>
                    <input type="time" name="actual_out" required value="19:30" class="w-full rounded-xl border-gray-200 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1">Keterangan / Pekerjaan Lembur</label>
                <textarea name="notes" rows="3" placeholder="Alasan atau tugas yang dikerjakan saat lembur..." class="w-full rounded-xl border-gray-200 text-sm focus:ring-indigo-500 focus:border-indigo-500"></textarea>
            </div>

            <div class="pt-4 border-t border-gray-100 flex justify-end gap-3">
                <a href="{{ route('overtime.index') }}" class="px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium text-sm rounded-xl transition">Batal</a>
                <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium text-sm rounded-xl transition shadow-sm">Kirim Pengajuan</button>
            </div>
        </form>
    </div>
</div>
@endsection
