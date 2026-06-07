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
    <form class="p-6 space-y-6">

        <!-- Nama Karyawan -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Nama Karyawan
            </label>
            <input type="text"
                   placeholder="Masukkan nama karyawan"
                   class="block w-full rounded-xl border-0 py-3 px-4 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-indigo-600 sm:text-sm">
        </div>

        <!-- Tanggal Mulai -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Tanggal Mulai
            </label>
            <input type="date"
                   class="block w-full rounded-xl border-0 py-3 px-4 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm">
        </div>

        <!-- Tanggal Selesai -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Tanggal Selesai
            </label>
            <input type="date"
                   class="block w-full rounded-xl border-0 py-3 px-4 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm">
        </div>

        <!-- Alasan -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Alasan
            </label>
            <textarea rows="4"
                      placeholder="Masukkan alasan pengajuan cuti"
                      class="block w-full rounded-xl border-0 py-3 px-4 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-indigo-600 sm:text-sm"></textarea>
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

@endsection