@extends('layouts.app')

@section('title', 'Slip Gaji Saya - ERP HRIS')

@section('content')
<div class="mb-6">
    <a href="{{ route('self-service.dashboard') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-800">&larr; Kembali ke Portal</a>
    <h1 class="text-2xl font-bold text-gray-900 tracking-tight mt-2">Slip Gaji Saya</h1>
    <p class="mt-1 text-sm text-gray-500">Lihat dan download slip gaji Anda per bulan.</p>
</div>

<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50/50 text-xs font-semibold text-gray-500 uppercase">
                    <th class="px-6 py-3.5">Periode</th>
                    <th class="px-6 py-3.5">Gaji Pokok</th>
                    <th class="px-6 py-3.5">Tunjangan</th>
                    <th class="px-6 py-3.5">Lembur</th>
                    <th class="px-6 py-3.5">Reimbursement</th>
                    <th class="px-6 py-3.5">Potongan</th>
                    <th class="px-6 py-3.5">Gaji Bersih</th>
                    <th class="px-6 py-3.5">Status</th>
                    <th class="px-6 py-3.5 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50 text-sm">
                @forelse($payslips as $p)
                <tr class="hover:bg-gray-50/60 transition-colors">
                    <td class="px-6 py-4 font-bold text-gray-900">
                        {{ DateTime::createFromFormat('!m', $p->month)->format('F') }} {{ $p->year }}
                    </td>
                    <td class="px-6 py-4 text-gray-600">Rp {{ number_format($p->basic_salary, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 text-gray-600">Rp {{ number_format($p->allowances + $p->position_allowance + $p->meal_allowance + $p->transport_allowance, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 text-indigo-600 font-medium">
                        @if($p->overtime_pay > 0)
                            Rp {{ number_format($p->overtime_pay, 0, ',', '.') }}
                            <div class="text-xs text-gray-400">({{ $p->overtime_hours }} Jam)</div>
                        @else
                            -
                        @endif
                    </td>
                    <td class="px-6 py-4 text-blue-600 font-medium">
                        @if($p->reimbursement_total > 0)
                            Rp {{ number_format($p->reimbursement_total, 0, ',', '.') }}
                        @else
                            -
                        @endif
                    </td>
                    <td class="px-6 py-4 text-red-600 font-medium">Rp {{ number_format($p->deductions + $p->pph21 + $p->bpjs_kesehatan + $p->bpjs_ketenagakerjaan, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 font-bold text-emerald-700 text-base">Rp {{ number_format($p->net_salary, 0, ',', '.') }}</td>
                    <td class="px-6 py-4">
                        @if(strtolower($p->status) === 'paid')
                            <span class="px-2.5 py-1 text-xs font-semibold text-emerald-700 bg-emerald-50 rounded-full">Paid</span>
                        @elseif(strtolower($p->status) === 'approved')
                            <span class="px-2.5 py-1 text-xs font-semibold text-blue-700 bg-blue-50 rounded-full">Approved</span>
                        @else
                            <span class="px-2.5 py-1 text-xs font-semibold text-amber-700 bg-amber-50 rounded-full">{{ ucfirst($p->status) }}</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        @if(strtolower($p->status) === 'paid')
                            <a href="{{ route('self-service.payslip.download', $p->id) }}" class="inline-flex items-center gap-1 px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-xs font-medium transition">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                </svg>
                                PDF
                            </a>
                        @else
                            <span class="text-xs text-gray-400">Menunggu Paid</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="px-6 py-8 text-center text-gray-400">Belum ada data slip gaji.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
