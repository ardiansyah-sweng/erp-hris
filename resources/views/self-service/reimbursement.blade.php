@extends('layouts.app')

@section('title', 'Klaim Reimbursement Saya - ERP HRIS')

@section('content')
<div class="mb-6">
    <a href="{{ route('self-service.dashboard') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-800">&larr; Kembali ke Portal</a>
    <h1 class="text-2xl font-bold text-gray-900 tracking-tight mt-2">Riwayat & Pengajuan Reimbursement Saya</h1>
    <p class="mt-1 text-sm text-gray-500">Ajukan klaim penggantian biaya dan tracking status klaim Anda.</p>
</div>

@if(session('success'))
<div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-sm font-medium">{{ session('success') }}</div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <!-- Riwayat Klaim -->
    <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <h2 class="text-base font-semibold text-gray-900">Riwayat Klaim</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50 text-xs font-semibold text-gray-500 uppercase">
                        <th class="px-6 py-3.5">Judul Klaim</th>
                        <th class="px-6 py-3.5">Kategori</th>
                        <th class="px-6 py-3.5">Tanggal</th>
                        <th class="px-6 py-3.5">Nominal</th>
                        <th class="px-6 py-3.5">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 text-sm">
                    @forelse($reimbursements as $r)
                    <tr class="hover:bg-gray-50/60 transition-colors">
                        <td class="px-6 py-4 font-semibold text-gray-900">{{ $r->title }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-0.5 text-xs font-medium bg-gray-100 text-gray-700 rounded-md">{{ $r->category_label }}</span>
                        </td>
                        <td class="px-6 py-4 text-gray-600">{{ $r->submission_date->format('d M Y') }}</td>
                        <td class="px-6 py-4 font-bold text-gray-900">Rp {{ number_format($r->amount, 0, ',', '.') }}</td>
                        <td class="px-6 py-4">
                            @if($r->status === 'approved')
                                <span class="px-2.5 py-1 text-xs font-semibold text-emerald-700 bg-emerald-50 rounded-full">Approved</span>
                            @elseif($r->status === 'rejected')
                                <span class="px-2.5 py-1 text-xs font-semibold text-red-700 bg-red-50 rounded-full">Rejected</span>
                            @else
                                <span class="px-2.5 py-1 text-xs font-semibold text-amber-700 bg-amber-50 rounded-full">Pending</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-400">Anda belum memiliki klaim reimbursement.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Form Ajukan Klaim -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <h2 class="text-base font-semibold text-gray-900 mb-4">Ajukan Klaim Baru</h2>
        <form action="{{ route('self-service.reimbursement.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1">Kategori</label>
                <select name="category" required class="w-full rounded-xl border-gray-200 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                    @foreach($categories as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1">Judul Klaim</label>
                <input type="text" name="title" required placeholder="Tiket Pesawat Dinas" class="w-full rounded-xl border-gray-200 text-sm focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1">Nominal (Rp)</label>
                <input type="number" step="1000" name="amount" required placeholder="500000" class="w-full rounded-xl border-gray-200 text-sm focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1">Tanggal</label>
                <input type="date" name="submission_date" required value="{{ date('Y-m-d') }}" class="w-full rounded-xl border-gray-200 text-sm focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1">Deskripsi</label>
                <textarea name="description" rows="2" class="w-full rounded-xl border-gray-200 text-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="Detail klaim..."></textarea>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1">Upload Bukti</label>
                <input type="file" name="receipt" accept="image/*,.pdf" class="w-full text-sm file:mr-3 file:py-2 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700">
            </div>

            <button type="submit" class="w-full py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium text-sm rounded-xl transition shadow-sm">Kirim Klaim</button>
        </form>
    </div>

</div>
@endsection
