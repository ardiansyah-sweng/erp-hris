@extends('layouts.app')

@section('title', 'Detail Absensi - ERP HRIS')

@section('content')

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

    <!-- Header -->
    <div class="flex items-start justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">
                Detail Absensi
            </h1>

            <p class="mt-2 text-sm text-gray-500">
                Informasi lengkap absensi karyawan.
            </p>
        </div>

        <a href="{{ route('absensi.index') }}"
           class="rounded-xl border border-gray-200 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50 transition">
            ← Kembali
        </a>
    </div>

    <!-- Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

        <!-- Header Card -->
        <div class="px-6 py-6 border-b border-gray-100">
            <h2 class="text-2xl font-bold text-gray-900">
                Budi Santoso
            </h2>

            <p class="text-gray-500 mt-1">
                Software Engineer
            </p>
        </div>

        <!-- Detail -->
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-8">

            <div>
                <p class="text-xs uppercase tracking-wider text-gray-400 font-semibold">
                    Nama Karyawan
                </p>

                <p class="mt-2 font-semibold text-gray-900">
                    Budi Santoso
                </p>
            </div>

            <div>
                <p class="text-xs uppercase tracking-wider text-gray-400 font-semibold">
                    Jabatan
                </p>

                <p class="mt-2 font-semibold text-gray-900">
                    Software Engineer
                </p>
            </div>

            <div>
                <p class="text-xs uppercase tracking-wider text-gray-400 font-semibold">
                    Tanggal
                </p>

                <p class="mt-2 font-semibold text-gray-900">
                    10 Juni 2026
                </p>
            </div>

            <div>
                <p class="text-xs uppercase tracking-wider text-gray-400 font-semibold">
                    Status
                </p>

                <div class="mt-2">
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-3 py-1 text-sm font-semibold text-emerald-700 ring-1 ring-inset ring-emerald-600/20">
                        <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                        Hadir
                    </span>
                </div>
            </div>

            <div>
                <p class="text-xs uppercase tracking-wider text-gray-400 font-semibold">
                    Jam Masuk
                </p>

                <p class="mt-2 font-semibold text-gray-900">
                    08:00
                </p>
            </div>

            <div>
                <p class="text-xs uppercase tracking-wider text-gray-400 font-semibold">
                    Jam Keluar
                </p>

                <p class="mt-2 font-semibold text-gray-900">
                    17:00
                </p>
            </div>

        </div>

    </div>

</div>

@endsection