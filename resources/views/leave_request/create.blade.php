@extends('layouts.app')

@section('content')

<!-- Header -->
<div class="sm:flex sm:items-center sm:justify-between mb-8">
    <div>
        <h1 class="text-2xl font-bold text-gray-900 tracking-tight">
            Pengajuan Cuti
        </h1>
        <p class="mt-1 text-sm text-gray-500">
            Isi formulir berikut untuk mengajukan cuti atau izin.
        </p>
    </div>

    <div class="mt-4 sm:mt-0">
        <a href="{{ route('leave_request.index') }}"
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
            Form Pengajuan Cuti
        </h3>
    </div>

    <!-- Form -->
    <form action="{{ route('leave_request.store') }}" method="POST" class="p-6 space-y-6">
        @csrf

        <!-- ID Karyawan -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                ID Karyawan
            </label>

            <input
                type="text"
                name="employee_id"
                id="employee_id"
                value="{{ old('employee_id') }}"
                placeholder="Contoh: EMP001"
                class="block w-full rounded-xl border-0 py-3 px-4 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-indigo-600 sm:text-sm">
        </div>      

        <!-- Nama Karyawan -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Nama Karyawan
            </label>
            <input
                type="text"
                name="employee_name"
                id="employee_name"
                value="{{ old('employee_name') }}"
                readonly
                placeholder="Nama Karyawan akan muncul otomatis"
                class="block w-full rounded-xl border-0 py-3 px-4 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-indigo-600 sm:text-sm">
        </div>

        <!-- Tanggal Mulai -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Tanggal Mulai
            </label>
            <input
                type="date"
                name="start_date"
                value="{{ old('start_date') }}"
                class="block w-full rounded-xl border-0 py-3 px-4 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm">
        </div>

        <!-- Tanggal Selesai -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Tanggal Selesai
            </label>
            <input
                type="date"
                name="end_date"
                value="{{ old('end_date') }}"
                class="block w-full rounded-xl border-0 py-3 px-4 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm">
        </div>

        <!-- Alasan -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Alasan
            </label>
            <textarea
                name="reason"
                rows="4"
                placeholder="Masukkan alasan pengajuan cuti"
                class="block w-full rounded-xl border-0 py-3 px-4 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-indigo-600 sm:text-sm">{{ old('reason') }}</textarea>
        </div>

        <!-- Status -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Status
            </label>
            <select name="status"
                class="block w-full rounded-xl border-0 py-3 px-4 text-gray-900 ring-1 ring-gray-300 focus:ring-2 focus:ring-indigo-600">
                <option value="Pending" {{ old('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                <option value="Approved" {{ old('status') == 'Approved' ? 'selected' : '' }}>Approved</option>
                <option value="Rejected" {{ old('status') == 'Rejected' ? 'selected' : '' }}>Rejected</option>
            </select>
        </div>

        <!-- Tombol -->
        <div class="flex justify-end gap-3 pt-5 border-t border-gray-100">

            <a href="{{ route('leave_request.index') }}"
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

    const employees = @json($employees->pluck('name', 'employee_code'));

    const employeeId = document.getElementById('employee_id');
    const employeeName = document.getElementById('employee_name');

    employeeId.addEventListener('keyup', function () {

        const id = this.value.toUpperCase();

        if (employees[id]) {
            employeeName.value = employees[id];
        } else {
            employeeName.value = '';
        }

    });

});
</script>

@endsection