@extends('layouts.app')

@section('content')

<div class="space-y-6">

    <!-- Header -->
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">
                Cuti & Izin
            </h1>
            <p class="mt-2 text-sm text-gray-500">
                Kelola seluruh pengajuan cuti dan izin karyawan
            </p>
        </div>

        <div class="mt-4 sm:mt-0">
            <a href="/leave-request/create"
            class="inline-flex items-center justify-center rounded-xl bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 transition-all">

                <svg class="mr-2 h-5 w-5"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 4v16m8-8H4" />
                </svg>

                Ajukan Cuti
            </a>
        </div>
    </div>

    <!-- Card Tabel -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

        <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center">

            <h3 class="text-base font-semibold text-gray-900">
                Daftar Pengajuan Cuti
            </h3>

            <div class="relative">

                <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                    <svg class="h-4 w-4 text-gray-400"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>

                <input type="text"
                    placeholder="Cari pengajuan..."
                    class="block w-full rounded-xl border-0 py-2 pl-10 pr-3 text-gray-900 ring-1 ring-gray-200 focus:ring-2 focus:ring-indigo-600 sm:text-sm">

            </div>

        </div>

        <div class="overflow-x-auto">

            <table class="min-w-full divide-y divide-gray-200">

                <thead class="bg-gray-50">

                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">
                            ID Karyawan
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">
                            Nama Karyawan
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">
                            Tanggal Mulai
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">
                            Tanggal Selesai
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">
                            Alasan
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">
                            Status
                        </th>

                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase">
                            Aksi
                        </th>
                    </tr>

                </thead>

                <tbody class="divide-y divide-gray-100 bg-white">

                @forelse($leaveRequests as $request)

                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $request->employee_id }}
                        </td>

                        <td class="px-6 py-4 text-sm font-medium text-gray-900">
                            {{ $request->employee_name }}
                        </td>

                        <td class="px-6 py-4 text-sm text-gray-600">
                           {{ $request->start_date }}
                        </td>

                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $request->end_date }}
                        </td>

                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $request->reason }}
                        </td>

                        <td class="px-6 py-4">

                            @if($request->status == 'Approved')

                                <span class="inline-flex rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                                    Approved
                                </span>

                            @elseif($request->status == 'Pending')

                                <span class="inline-flex rounded-full bg-yellow-100 px-3 py-1 text-xs font-semibold text-yellow-700">
                                    Pending
                                </span>

                            @else

                                <span class="inline-flex rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">
                                    Rejected
                                </span>

                            @endif

                        </td>

                        <td class="px-6 py-4">

                            <div class="flex justify-end gap-2">

                                <a href="{{ route('leave_request.detail', $request->id) }}"
                                    class="text-sky-600 hover:text-sky-900 bg-sky-50 hover:bg-sky-100 px-3 py-1.5 rounded-lg">
                                    Detail
                                </a>

                                <a href="{{ route('leave_request.edit', $request->id) }}"
                                    class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 px-3 py-1.5 rounded-lg">
                                    Edit
                                </a>
                                
                                <form action="{{ route('leave_request.destroy', $request->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus pengajuan ini?')">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                        class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg">
                                        Hapus
                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="6" class="py-16 text-center">

                            <div class="flex flex-col items-center">

                                <svg class="h-12 w-12 text-gray-300 mb-4"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor">

                                    <path stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.5"
                                        d="M8 7V3m8 4V3m-9 8h10m-11 9h12a2 2 0 002-2V7a2 2 0 00-2-2H6a2 2 0 00-2 2v11a2 2 0 002 2z"/>
                                </svg>

                                <h3 class="text-sm font-semibold text-gray-900">
                                    Belum ada Pengajuan Cuti
                                </h3>

                                <p class="mt-1 text-sm text-gray-500">
                                    Belum ada data pengajuan cuti yang tersedia.
                                </p>

                            </div>

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection