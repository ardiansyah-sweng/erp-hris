@extends('layouts.app')

@section('title', 'Pengajuan Reimbursement - ERP HRIS')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('reimbursement.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-800 flex items-center gap-1">
            &larr; Kembali ke Daftar Reimbursement
        </a>
        <h1 class="text-2xl font-bold text-gray-900 tracking-tight mt-2">Form Pengajuan Reimbursement</h1>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <form action="{{ route('reimbursement.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
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

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1">Kategori Klaim</label>
                    <select name="category" required class="w-full rounded-xl border-gray-200 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                        @foreach($categories as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1">Tanggal Pengajuan</label>
                    <input type="date" name="submission_date" required value="{{ date('Y-m-d') }}" class="w-full rounded-xl border-gray-200 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1">Judul / Keperluan Klaim</label>
                <input type="text" name="title" required placeholder="Contoh: Tiket Pesawat Perjalanan Dinas Jakarta" class="w-full rounded-xl border-gray-200 text-sm focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1">Jumlah Nominal (Rp)</label>
                <input type="number" step="1000" name="amount" required placeholder="500000" class="w-full rounded-xl border-gray-200 text-sm focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1">Deskripsi / Catatan Tambahan</label>
                <textarea name="description" rows="3" placeholder="Penjelasan detail rincian klaim biaya..." class="w-full rounded-xl border-gray-200 text-sm focus:ring-indigo-500 focus:border-indigo-500"></textarea>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1">Upload Bukti Transaksi / Nota (Receipt)</label>
                <input type="file" name="receipt" accept="image/*,.pdf" class="w-full rounded-xl border-gray-200 text-sm focus:ring-indigo-500 focus:border-indigo-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                <p class="text-xs text-gray-400 mt-1">Format: JPG, PNG, PDF. Maksimal 2MB.</p>
            </div>

            <div class="pt-4 border-t border-gray-100 flex justify-end gap-3">
                <a href="{{ route('reimbursement.index') }}" class="px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium text-sm rounded-xl transition">Batal</a>
                <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium text-sm rounded-xl transition shadow-sm">Kirim Pengajuan Klaim</button>
            </div>
        </form>
    </div>
</div>
@endsection
