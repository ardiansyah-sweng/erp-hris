@extends('layouts.app')

@section('title', 'Audit Logs - ERP HRIS')

@section('content')

    <div class="sm:flex sm:items-center sm:justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Sistem Audit Log</h1>
            <p class="mt-1 text-sm text-gray-500">
                Pantau seluruh rekam jejak aktivitas manipulasi data (CRUD) pada sistem secara real-time.
            </p>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4 mb-8">
        <div class="bg-white overflow-hidden rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col transition-transform hover:-translate-y-1 duration-300">
            <div class="flex items-center mb-2">
                <div class="p-2.5 rounded-xl bg-indigo-50 text-indigo-600 mr-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <p class="text-sm font-medium text-gray-500">Total Log Sistem</p>
            </div>
            <div class="flex items-baseline gap-2">
                <p class="text-3xl font-bold text-gray-900">{{ count($logs) }}</p>
                <span class="text-sm text-indigo-600 font-medium">aktivitas terekam</span>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow duration-300">
        
        <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center">
            <h3 class="text-base font-semibold text-gray-900">Daftar Rekam Aktivitas</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50/50">
                    <tr>
                        <th class="py-4 pl-6 pr-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-widest">No</th>
                        <th class="px-3 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-widest">Aktor (User)</th>
                        <th class="px-3 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-widest">Aksi</th>
                        <th class="px-3 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-widest">Modul</th>
                        <th class="px-3 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-widest">Deskripsi Aktivitas</th>
                        <th class="py-4 pl-3 pr-6 text-right text-xs font-semibold text-gray-500 uppercase tracking-widest">Waktu Kejadian</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @forelse($logs as $log)
                        <tr class="hover:bg-indigo-50/40 transition-colors duration-150 group">
                            <td class="whitespace-nowrap py-4 pl-6 pr-3 text-sm font-medium text-gray-900">{{ $loop->iteration }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm font-semibold text-gray-900">
                                {{ $log->user_email }}
                            </td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm">
                                @if($log->action === 'CREATE')
                                    <span class="inline-flex items-center rounded-md bg-emerald-50 px-2 py-1 text-xs font-semibold text-emerald-700 ring-1 ring-inset ring-emerald-700/10">
                                        CREATE
                                    </span>
                                @elseif($log->action === 'UPDATE')
                                    <span class="inline-flex items-center rounded-md bg-amber-50 px-2 py-1 text-xs font-semibold text-amber-700 ring-1 ring-inset ring-amber-700/10">
                                        UPDATE
                                    </span>
                                @else
                                    <span class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-semibold text-red-700 ring-1 ring-inset ring-red-700/10">
                                        DELETE
                                    </span>
                                @endif
                            </td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-600">
                                <span class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-semibold text-blue-700 ring-1 ring-inset ring-blue-700/10">
                                    {{ $log->module }}
                                </span>
                            </td>
                            <td class="px-3 py-4 text-sm text-gray-500 max-w-xs truncate" title="{{ $log->description }}">
                                {{ $log->description }}
                            </td>
                            <td class="whitespace-nowrap py-4 pl-3 pr-6 text-right text-xs font-medium text-gray-400">
                                {{ \Carbon\Carbon::parse($log->created_at)->translatedFormat('d M Y, H:i') }} WIB
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-16 text-center">
                                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-50 mb-4">
                                    <svg class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 009 11V7a4 4 0 00-8 0v4c0 2.451.836 4.707 2.229 6.517m2.44-2.04c.516-.305 1.1-.471 1.732-.471h3.158c.633 0 1.217.166 1.733.471m-1.733-.471V4a2 2 0 114 0v5c0 1.018-.223 1.984-.62 2.854m0 0a13.96 13.96 0 012.753 9.571m0 0A13.952 13.952 0 0022 11V7a4 4 0 00-8 0v4c0 2.451.836 4.707 2.23 6.517M11 21h2" />
                                    </svg>
                                </div>
                                <h3 class="text-sm font-semibold text-gray-900">Belum ada data log</h3>
                                <p class="mt-1 text-sm text-gray-500">Seluruh aktivitas perubahan data sistem akan terekam otomatis di sini.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection