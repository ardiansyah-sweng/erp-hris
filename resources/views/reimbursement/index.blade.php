@extends('layouts.app')

@section('title', 'Klaim Reimbursement - ERP HRIS')

@section('content')
<div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div>
        <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Klaim Reimbursement (Expense)</h1>
        <p class="mt-1 text-sm text-gray-500">Kelola dan selesaikan pengajuan penggantian biaya karyawan.</p>
    </div>
    <div>
        <a href="{{ route('reimbursement.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium text-sm rounded-xl transition shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Ajukan Klaim Baru
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

<!-- Filter Bar -->
<div class="mb-6 bg-white rounded-2xl border border-gray-100 shadow-sm p-4">
    <form method="GET" action="{{ route('reimbursement.index') }}" class="grid grid-cols-1 sm:grid-cols-4 gap-4">
        <div>
            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Status</label>
            <select name="status" class="w-full rounded-xl border-gray-200 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">Semua Status</option>
                <option value="pending" {{ ($filters['status'] ?? '') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="approved" {{ ($filters['status'] ?? '') == 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="rejected" {{ ($filters['status'] ?? '') == 'rejected' ? 'selected' : '' }}>Rejected</option>
            </select>
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Kategori</label>
            <select name="category" class="w-full rounded-xl border-gray-200 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">Semua Kategori</option>
                <option value="transport" {{ ($filters['category'] ?? '') == 'transport' ? 'selected' : '' }}>Transport</option>
                <option value="medical" {{ ($filters['category'] ?? '') == 'medical' ? 'selected' : '' }}>Medical</option>
                <option value="meal" {{ ($filters['category'] ?? '') == 'meal' ? 'selected' : '' }}>Uang Makan</option>
                <option value="training" {{ ($filters['category'] ?? '') == 'training' ? 'selected' : '' }}>Training</option>
                <option value="other" {{ ($filters['category'] ?? '') == 'other' ? 'selected' : '' }}>Lain-lain</option>
            </select>
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Karyawan</label>
            <select name="employee_id" class="w-full rounded-xl border-gray-200 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">Semua Karyawan</option>
                @foreach($employees as $e)
                    <option value="{{ $e->id }}" {{ ($filters['employee_id'] ?? '') == $e->id ? 'selected' : '' }}>{{ $e->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex items-end">
            <button type="submit" class="w-full py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium text-sm rounded-xl transition">Filter</button>
        </div>
    </form>
</div>

<!-- Table -->
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50/50 text-xs font-semibold text-gray-500 uppercase">
                    <th class="px-6 py-3.5">Karyawan</th>
                    <th class="px-6 py-3.5">Judul Klaim & Kategori</th>
                    <th class="px-6 py-3.5">Tanggal Pengajuan</th>
                    <th class="px-6 py-3.5">Jumlah Klaim</th>
                    <th class="px-6 py-3.5">Status</th>
                    <th class="px-6 py-3.5 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50 text-sm">
                @forelse($reimbursements as $r)
                <tr class="hover:bg-gray-50/60 transition-colors">
                    <td class="px-6 py-4">
                        <div class="font-semibold text-gray-900">{{ $r->employee->name ?? '-' }}</div>
                        <div class="text-xs text-gray-400">{{ $r->employee->jobrole->role ?? '-' }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <a href="{{ route('reimbursement.show', $r->id) }}" class="font-semibold text-indigo-600 hover:underline">{{ $r->title }}</a>
                        <div class="text-xs text-gray-400 font-medium">{{ $r->category_label }}</div>
                    </td>
                    <td class="px-6 py-4 text-gray-600 font-medium">{{ $r->submission_date->format('d M Y') }}</td>
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
                    <td class="px-6 py-4 text-right flex justify-end gap-2">
                        <a href="{{ route('reimbursement.show', $r->id) }}" class="px-2.5 py-1 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-xs font-medium transition">Detail</a>
                        @if($r->status === 'pending')
                            <form action="{{ route('reimbursement.approve', $r->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="px-2.5 py-1 bg-emerald-600 text-white rounded-lg text-xs font-medium hover:bg-emerald-700 transition">Approve</button>
                            </form>
                            <form action="{{ route('reimbursement.reject', $r->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="px-2.5 py-1 bg-red-600 text-white rounded-lg text-xs font-medium hover:bg-red-700 transition">Reject</button>
                            </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-gray-400">Tidak ada data klaim reimbursement.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
