@extends('layouts.app')

@section('title', 'Karyawan - ERP HRIS')

@section('content')

<div class="sm:flex sm:items-center sm:justify-between mb-8">
    <div>
        <h1 class="text-2xl font-bold text-gray-900 tracking-tight">
            Manajemen Karyawan
        </h1>
        <p class="mt-1 text-sm text-gray-500">
            Kelola dan pantau data karyawan perusahaan.
        </p>
    </div>
</div>

<!-- Statistik -->
<div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4 mb-8">

    <div class="bg-white overflow-hidden rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center mb-2">
            <div class="p-2.5 rounded-xl bg-indigo-50 text-indigo-600 mr-3">
                👥
            </div>
            <p class="text-sm font-medium text-gray-500">
                Total Karyawan
            </p>
        </div>

        <div class="flex items-baseline gap-2">
            <p class="text-3xl font-bold text-gray-900">
                {{ count($employees) }}
            </p>
            <span class="text-sm text-indigo-600 font-medium">
                karyawan
            </span>
        </div>
    </div>

    <div class="bg-white overflow-hidden rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center mb-2">
            <div class="p-2.5 rounded-xl bg-emerald-50 text-emerald-600 mr-3">
                ✅
            </div>
            <p class="text-sm font-medium text-gray-500">
                Aktif
            </p>
        </div>

        <div class="flex items-baseline gap-2">
            <p class="text-3xl font-bold text-gray-900">
                {{ count($employees) }}
            </p>
            <span class="text-sm text-emerald-600 font-medium">
                aktif
            </span>
        </div>
    </div>

    <div class="bg-white overflow-hidden rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center mb-2">
            <div class="p-2.5 rounded-xl bg-blue-50 text-blue-600 mr-3">
                📧
            </div>
            <p class="text-sm font-medium text-gray-500">
                Email Terdaftar
            </p>
        </div>

        <div class="flex items-baseline gap-2">
            <p class="text-3xl font-bold text-gray-900">
                {{ count($employees) }}
            </p>
            <span class="text-sm text-blue-600 font-medium">
                email
            </span>
        </div>
    </div>

    <div class="bg-white overflow-hidden rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center mb-2">
            <div class="p-2.5 rounded-xl bg-amber-50 text-amber-600 mr-3">
                🎂
            </div>
            <p class="text-sm font-medium text-gray-500">
                Data Karyawan
            </p>
        </div>

        <div class="flex items-baseline gap-2">
            <p class="text-3xl font-bold text-gray-900">
                {{ count($employees) }}
            </p>
            <span class="text-sm text-amber-600 font-medium">
                tersedia
            </span>
        </div>
    </div>

</div>

<!-- Tabel -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow duration-300">

    <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center">
        <h3 class="text-base font-semibold text-gray-900">
            Daftar Karyawan
        </h3>

        <div class="relative">
            <input
                type="text"
                class="block w-full rounded-xl border-0 py-2 px-4 text-gray-900 ring-1 ring-inset ring-gray-200 placeholder:text-gray-400"
                placeholder="Cari karyawan..."
            >
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">

            <thead class="bg-gray-50/50">
                <tr>
                    <th class="py-4 pl-6 pr-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-widest">
                        ID
                    </th>

                    <th class="px-3 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-widest">
                        Nama
                    </th>

                    <th class="px-3 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-widest">
                        Email
                    </th>

                    <th class="px-3 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-widest">
                        No HP
                    </th>

                    <th class="px-3 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-widest">
                        Tempat Lahir
                    </th>

                    <th class="px-3 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-widest">
                        Tanggal Lahir
                    </th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100 bg-white">

                @forelse($employees as $employee)

                <tr class="hover:bg-indigo-50/40 transition-colors duration-150">

                    <td class="py-4 pl-6 pr-3 text-sm font-medium text-gray-900">
                        {{ $employee->id }}
                    </td>

                    <td class="px-3 py-4 text-sm font-semibold text-gray-900">
                        {{ $employee->name }}
                    </td>

                    <td class="px-3 py-4 text-sm text-gray-600">
                        {{ $employee->email }}
                    </td>

                    <td class="px-3 py-4 text-sm text-gray-600">
                        {{ $employee->phone_number }}
                    </td>

                    <td class="px-3 py-4 text-sm text-gray-600">
                        {{ $employee->place_of_birth }}
                    </td>

                    <td class="px-3 py-4 text-sm text-gray-600">
                        {{ $employee->date_of_birth }}
                    </td>

                </tr>

                @empty

                <tr>
                    <td colspan="6" class="py-16 text-center">
                        <h3 class="text-sm font-semibold text-gray-900">
                            Belum ada data karyawan
                        </h3>
                    </td>
                </tr>

                @endforelse

            </tbody>

        </table>
    </div>

</div>

@endsection