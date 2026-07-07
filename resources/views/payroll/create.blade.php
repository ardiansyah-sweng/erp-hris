@extends('layouts.app')

@section('title', 'Tambah Payroll - ERP HRIS')

@section('content')

<!-- Header -->
<div class="sm:flex sm:items-center sm:justify-between mb-8">
    <div>
        <h1 class="text-2xl font-bold text-gray-900 tracking-tight">
            Tambah Gaji Baru
        </h1>
        <p class="mt-1 text-sm text-gray-500">
            Isi formulir berikut sesuai kolom pada tabel riwayat penggajian.
        </p>
    </div>

    <div class="mt-4 sm:mt-0">
        <a href="{{ route('payroll.index') }}"
           class="inline-flex items-center rounded-xl border border-gray-300 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50 transition-all">

            <svg class="mr-2 h-5 w-5"
                 fill="none"
                 stroke="currentColor"
                 viewBox="0 0 24 24">
                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M15 19l-7-7 7-7"/>
            </svg>

            Kembali
        </a>
    </div>
</div>

<!-- Form Card -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

    <!-- Card Header -->
    <div class="px-6 py-5 border-b border-gray-100">
        <h3 class="text-base font-semibold text-gray-900">
            Form Tambah Gaji Baru
        </h3>
    </div>

    <!-- Form -->
    <form action="{{ route('payroll.store') }}" method="POST" class="p-6 space-y-6">
        @csrf

        <!-- Nama Karyawan -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Nama Karyawan
            </label>

            <select
                id="employee_id"
                name="employee_id"
                required
                class="block w-full rounded-xl border-0 py-3 px-4 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm bg-white">
                <option value="">Pilih Karyawan</option>
                @foreach($employees as $employee)
                    <option value="{{ $employee->id }}" @selected(old('employee_id') == $employee->id)>
                        {{ $employee->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Periode -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Periode
            </label>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <select
                    id="month"
                    name="month"
                    required
                    class="block w-full rounded-xl border-0 py-3 px-4 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm bg-white">
                    <option value="">Pilih Bulan</option>
                    <option value="1" @selected(old('month') == 1)>Januari</option>
                    <option value="2" @selected(old('month') == 2)>Februari</option>
                    <option value="3" @selected(old('month') == 3)>Maret</option>
                    <option value="4" @selected(old('month') == 4)>April</option>
                    <option value="5" @selected(old('month') == 5)>Mei</option>
                    <option value="6" @selected(old('month') == 6)>Juni</option>
                    <option value="7" @selected(old('month') == 7)>Juli</option>
                    <option value="8" @selected(old('month') == 8)>Agustus</option>
                    <option value="9" @selected(old('month') == 9)>September</option>
                    <option value="10" @selected(old('month') == 10)>Oktober</option>
                    <option value="11" @selected(old('month') == 11)>November</option>
                    <option value="12" @selected(old('month') == 12)>Desember</option>
                </select>

                <input
                    type="number"
                    id="year"
                    name="year"
                    value="{{ old('year') }}"
                    required
                    placeholder="Contoh: 2026"
                    class="block w-full rounded-xl border-0 py-3 px-4 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-indigo-600 sm:text-sm">
            </div>
        </div>

        <!-- Gaji Pokok -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Gaji Pokok
            </label>

            <input
                type="number"
                id="basic_salary"
                name="basic_salary"
                value="{{ old('basic_salary') }}"
                min="0"
                required
                placeholder="Contoh: 5000000"
                class="payroll-amount block w-full rounded-xl border-0 py-3 px-4 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-indigo-600 sm:text-sm">
        </div>

        <!-- Tunjangan -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Tunjangan
            </label>

            <input
                type="number"
                id="allowances"
                name="allowances"
                value="{{ old('allowances') }}"
                min="0"
                placeholder="Contoh: 500000"
                class="payroll-amount block w-full rounded-xl border-0 py-3 px-4 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-indigo-600 sm:text-sm">
        </div>

        <!-- Potongan -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Potongan
            </label>

            <input
                type="number"
                id="deductions"
                name="deductions"
                value="{{ old('deductions') }}"
                min="0"
                placeholder="Contoh: 150000"
                class="payroll-amount block w-full rounded-xl border-0 py-3 px-4 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-indigo-600 sm:text-sm">
        </div>

        <!-- Total Bersih -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Gaji Bersih
            </label>

            <input
                type="text"
                id="net_salary"
                readonly
                placeholder="Total bersih akan muncul otomatis"
                class="block w-full rounded-xl border-0 py-3 px-4 text-gray-900 font-semibold ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-indigo-600 sm:text-sm bg-gray-50">
        </div>

        <!-- Status -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Status
            </label>

            <select
                id="status"
                name="status"
                class="block w-full rounded-xl border-0 py-3 px-4 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm bg-white">
                <option value="">Pilih Status</option>
                <option value="pending" @selected(old('status') == 'pending')>Pending</option>
                <option value="approved" @selected(old('status') == 'approved')>Approved</option>
                <option value="paid" @selected(old('status') == 'paid')>Paid</option>
            </select>
        </div>

        <!-- Tombol -->
        <div class="flex justify-end gap-3 pt-5 border-t border-gray-100">

            <a href="{{ route('payroll.index') }}"
               class="rounded-xl border border-gray-300 px-5 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50 transition-all">
                Batal
            </a>

            <button type="submit"
                    class="inline-flex items-center rounded-xl bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 transition-all">
                Submit
            </button>

        </div>

    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const basicSalary = document.getElementById('basic_salary');
    const allowances = document.getElementById('allowances');
    const deductions = document.getElementById('deductions');
    const netSalary = document.getElementById('net_salary');

    const formatter = new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        maximumFractionDigits: 0
    });

    function toNumber(input) {
        return Number(input.value || 0);
    }

    function updateNetSalary() {
        const total = toNumber(basicSalary) + toNumber(allowances) - toNumber(deductions);
        netSalary.value = total > 0 ? formatter.format(total) : '';
    }

    document.querySelectorAll('.payroll-amount').forEach(function (input) {
        input.addEventListener('input', updateNetSalary);
    });

});
</script>

@endsection
