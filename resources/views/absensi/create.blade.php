@extends('layouts.app')

@section('title', 'Tambah Absensi - ERP HRIS')

@section('content')

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 tracking-tight">
            Tambah Absensi
        </h1>

        <p class="mt-2 text-sm text-gray-500">
            Tambahkan data absensi karyawan.
        </p>
    </div>

    <!-- Card Form -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

        <!-- Header Card -->
        <div class="px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-indigo-50 to-white">
            <h2 class="text-lg font-semibold text-gray-900">
                Form Tambah Absensi
            </h2>

            <p class="mt-1 text-sm text-gray-500">
                Lengkapi informasi absensi di bawah ini.
            </p>
        </div>

        <!-- Form -->
        <form class="p-6">

            <!-- Nama Karyawan -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Nama Karyawan
                </label>

                <input
                    type="text"
                    placeholder="Masukkan nama karyawan"
                    class="w-full px-4 py-3 rounded-xl border-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                >
            </div>

            <!-- Tanggal -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Tanggal
                </label>

                <input
                    type="date"
                    class="w-full px-4 py-3 rounded-xl border-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                >
            </div>

            <!-- Jam Masuk -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Jam Masuk
                </label>

                <input
                    type="time"
                    class="w-full px-4 py-3 rounded-xl border-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                >
            </div>

            <!-- Jam Keluar -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Jam Keluar
                </label>

                <input
                    type="time"
                    class="w-full px-4 py-3 rounded-xl border-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                >
            </div>

            <!-- Status -->
            <div class="mb-8">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Status
                </label>

                <select
                    class="w-full rounded-xl border-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                >
                    <option>Hadir</option>
                    <option>Tidak Hadir</option>
                    <option>Terlambat</option>
                </select>
            </div>

            <!-- Tombol -->
            <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-100">

                <a href="{{ route('absensi.index') }}"
                   class="rounded-xl border border-gray-200 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50 transition">
                    Kembali
                </a>

                <button
                    type="submit"
                    class="rounded-xl bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 transition-all duration-200"
                >
                    Simpan Absensi
                </button>

            </div>

        </form>

    </div>

</div>

@endsection