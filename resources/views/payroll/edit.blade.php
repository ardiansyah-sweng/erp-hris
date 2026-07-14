@extends('layouts.app')

@section('title', 'Edit Penggajian - ERP HRIS')

@section('content')

@php
    $namaBulan = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                  'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
@endphp

<div class="space-y-6 max-w-3xl">

    <div>
        <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Edit Penggajian</h1>
        <p class="mt-1 text-sm text-gray-500">
            Ubah data kompensasi karyawan. Total gaji bersih dihitung otomatis saat disimpan.
        </p>
    </div>

    {{-- Tampilkan ringkasan error validasi --}}
    @if ($errors->any())
        <div class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
            <p class="font-semibold mb-1">Periksa kembali isian berikut:</p>
            <ul class="list-disc list-inside space-y-0.5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

        <div class="px-6 py-5 border-b border-gray-100">
            <h3 class="text-base font-semibold text-gray-900">Form Edit Slip Gaji</h3>
        </div>

        <form action="{{ route('payroll.update', $payroll->id) }}" method="POST" class="p-6 space-y-5">
            @csrf
            @method('PUT')

            {{-- Karyawan --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Karyawan</label>
                <select name="employee_id"
                    class="block w-full rounded-xl border-0 py-2.5 px-4 text-gray-900 ring-1 ring-gray-200 focus:ring-2 focus:ring-indigo-600 sm:text-sm">
                    @foreach ($employees as $employee)
                        <option value="{{ $employee->id }}"
                            {{ (int) old('employee_id', $payroll->employee_id) === $employee->id ? 'selected' : '' }}>
                            {{ $employee->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Periode --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Bulan</label>
                    <select name="month"
                        class="block w-full rounded-xl border-0 py-2.5 px-4 text-gray-900 ring-1 ring-gray-200 focus:ring-2 focus:ring-indigo-600 sm:text-sm">
                        @for ($m = 1; $m <= 12; $m++)
                            <option value="{{ $m }}"
                                {{ (int) old('month', $payroll->month) === $m ? 'selected' : '' }}>
                                {{ $namaBulan[$m] }}
                            </option>
                        @endfor
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tahun</label>
                    <input type="number" name="year" value="{{ old('year', $payroll->year) }}"
                        class="block w-full rounded-xl border-0 py-2.5 px-4 text-gray-900 ring-1 ring-gray-200 focus:ring-2 focus:ring-indigo-600 sm:text-sm">
                </div>
            </div>

            {{-- Gaji pokok --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Gaji Pokok (Rp)</label>
                <input type="number" step="0.01" name="basic_salary" value="{{ old('basic_salary', $payroll->basic_salary) }}"
                    class="block w-full rounded-xl border-0 py-2.5 px-4 text-gray-900 ring-1 ring-gray-200 focus:ring-2 focus:ring-indigo-600 sm:text-sm">
            </div>

            {{-- Tunjangan & potongan --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tunjangan (Rp)</label>
                    <input type="number" step="0.01" name="allowances" value="{{ old('allowances', $payroll->allowances) }}"
                        class="block w-full rounded-xl border-0 py-2.5 px-4 text-gray-900 ring-1 ring-gray-200 focus:ring-2 focus:ring-indigo-600 sm:text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Potongan (Rp)</label>
                    <input type="number" step="0.01" name="deductions" value="{{ old('deductions', $payroll->deductions) }}"
                        class="block w-full rounded-xl border-0 py-2.5 px-4 text-gray-900 ring-1 ring-gray-200 focus:ring-2 focus:ring-indigo-600 sm:text-sm">
                </div>
            </div>

            {{-- Status --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select name="status"
                    class="block w-full rounded-xl border-0 py-2.5 px-4 text-gray-900 ring-1 ring-gray-200 focus:ring-2 focus:ring-indigo-600 sm:text-sm">
                    <option value="pending" {{ old('status', $payroll->status) === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="paid" {{ old('status', $payroll->status) === 'paid' ? 'selected' : '' }}>Paid</option>
                </select>
            </div>

            <div class="flex justify-end gap-4 pt-4">
                <a href="{{ route('payroll.index') }}"
                    class="rounded-xl bg-gray-100 px-5 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-200 transition-all">
                    Batal
                </a>
                <button type="submit"
                    class="rounded-xl bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 transition-all">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

</div>

@endsection
