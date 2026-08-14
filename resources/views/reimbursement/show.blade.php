@extends('layouts.app')

@section('title', 'Detail Reimbursement - ERP HRIS')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <a href="{{ route('reimbursement.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-800 flex items-center gap-1">
                &larr; Kembali ke Daftar Reimbursement
            </a>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight mt-2">Detail Pengajuan Reimbursement</h1>
        </div>
        <div>
            @if($reimbursement->status === 'approved')
                <span class="px-3 py-1.5 text-sm font-semibold text-emerald-700 bg-emerald-50 border border-emerald-200 rounded-full">Approved</span>
            @elseif($reimbursement->status === 'rejected')
                <span class="px-3 py-1.5 text-sm font-semibold text-red-700 bg-red-50 border border-red-200 rounded-full">Rejected</span>
            @else
                <span class="px-3 py-1.5 text-sm font-semibold text-amber-700 bg-amber-50 border border-amber-200 rounded-full">Pending Approval</span>
            @endif
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden mb-6 p-6 space-y-6">
        <div class="grid grid-cols-2 gap-6 border-b border-gray-100 pb-6">
            <div>
                <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider block">Karyawan Pemohon</span>
                <span class="text-base font-bold text-gray-900 block mt-1">{{ $reimbursement->employee->name ?? '-' }}</span>
                <span class="text-xs text-gray-500 block">{{ $reimbursement->employee->jobrole->role ?? '-' }}</span>
            </div>
            <div>
                <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider block">Tanggal Pengajuan</span>
                <span class="text-base font-bold text-gray-900 block mt-1">{{ $reimbursement->submission_date->format('d F Y') }}</span>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-6 border-b border-gray-100 pb-6">
            <div>
                <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider block">Judul Klaim</span>
                <span class="text-lg font-bold text-indigo-600 block mt-1">{{ $reimbursement->title }}</span>
                <span class="inline-block mt-1 px-2.5 py-0.5 text-xs font-medium bg-gray-100 text-gray-700 rounded-md">{{ $reimbursement->category_label }}</span>
            </div>
            <div>
                <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider block">Jumlah Nominal</span>
                <span class="text-2xl font-bold text-emerald-600 block mt-1">Rp {{ number_format($reimbursement->amount, 0, ',', '.') }}</span>
            </div>
        </div>

        <div>
            <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider block">Deskripsi / Catatan</span>
            <p class="text-sm text-gray-700 mt-1 leading-relaxed">{{ $reimbursement->description ?? 'Tidak ada deskripsi tambahan.' }}</p>
        </div>

        @if($reimbursement->receipt_path)
        <div class="border-t border-gray-100 pt-6">
            <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider block mb-2">Bukti Transaksi (Receipt)</span>
            <div class="bg-gray-50 p-4 rounded-xl border border-gray-200 inline-block">
                <a href="{{ asset('storage/' . $reimbursement->receipt_path) }}" target="_blank" class="text-sm font-semibold text-indigo-600 hover:underline flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    Lihat Bukti Transaksi
                </a>
            </div>
        </div>
        @endif

        @if($reimbursement->status === 'pending')
        <div class="border-t border-gray-100 pt-6 flex justify-end gap-3">
            <form action="{{ route('reimbursement.approve', $reimbursement->id) }}" method="POST">
                @csrf
                <button type="submit" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-medium text-sm rounded-xl transition shadow-sm">
                    Approve Klaim Ini
                </button>
            </form>
            <form action="{{ route('reimbursement.reject', $reimbursement->id) }}" method="POST">
                @csrf
                <button type="submit" class="px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white font-medium text-sm rounded-xl transition shadow-sm">
                    Reject Klaim Ini
                </button>
            </form>
        </div>
        @endif
    </div>
</div>
@endsection
