@extends('layouts.app')

@section('title', 'Edit Shift Kerja - ERP HRIS')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('shifts.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-800 flex items-center gap-1">
            &larr; Kembali ke Daftar Shift
        </a>
        <h1 class="text-2xl font-bold text-gray-900 tracking-tight mt-2">Edit Master Shift</h1>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <form action="{{ route('shifts.update', $shift->id) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1">Nama Shift</label>
                <input type="text" name="name" required value="{{ $shift->name }}" class="w-full rounded-xl border-gray-200 text-sm focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1">Jam Masuk</label>
                    <input type="time" name="start_time" required value="{{ $shift->start_time }}" class="w-full rounded-xl border-gray-200 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1">Jam Keluar</label>
                    <input type="time" name="end_time" required value="{{ $shift->end_time }}" class="w-full rounded-xl border-gray-200 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1">Total Jam Kerja (Efektif)</label>
                <input type="number" step="0.5" name="total_hours" required value="{{ $shift->total_hours }}" class="w-full rounded-xl border-gray-200 text-sm focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_active" id="is_active" value="1" {{ $shift->is_active ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                <label for="is_active" class="text-sm font-medium text-gray-700">Aktifkan Shift Ini</label>
            </div>

            <div class="pt-4 border-t border-gray-100 flex justify-end gap-3">
                <a href="{{ route('shifts.index') }}" class="px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium text-sm rounded-xl transition">Batal</a>
                <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium text-sm rounded-xl transition shadow-sm">Perbarui Shift</button>
            </div>
        </form>
    </div>
</div>
@endsection
