@extends('layouts.app')

@section('content')

<div class="space-y-6">

    <!-- Header -->
    <div class="sm:flex sm:items-center sm:justify-between">

        <div>
            <h1 class="text-2xl font-bold text-gray-900">
                Riwayat Cuti Karyawan
            </h1>

            <p class="mt-2 text-sm text-gray-500">
                Menampilkan seluruh riwayat pengajuan cuti dan izin karyawan.
            </p>
        </div>

        <a href="{{ route('leave_request.index') }}"
            class="inline-flex items-center rounded-xl border border-gray-300 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50">

            Kembali
        </a>

    </div>

    <!-- Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

        <div class="px-6 py-5 border-b border-gray-100">

            <h3 class="text-base font-semibold text-gray-900">
                Data Riwayat Cuti
            </h3>

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
                            Jenis Cuti
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">
                            Tanggal Mulai
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">
                            Tanggal Selesai
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">
                            Status
                        </th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-gray-100 bg-white">

                    @foreach($leaveHistories as $history)

                    <tr class="hover:bg-gray-50">

                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $history['employee_id'] }}
                        </td>

                        <td class="px-6 py-4 text-sm font-medium text-gray-900">
                            {{ $history['employee_name'] }}
                        </td>

                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $history['leave_type'] }}
                        </td>

                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $history['start_date'] }}
                        </td>

                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $history['end_date'] }}
                        </td>

                        <td class="px-6 py-4">

                            @if($history['status'] == 'Approved')

                                <span class="inline-flex rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                                    Approved
                                </span>

                            @elseif($history['status'] == 'Pending')

                                <span class="inline-flex rounded-full bg-yellow-100 px-3 py-1 text-xs font-semibold text-yellow-700">
                                    Pending
                                </span>

                            @else

                                <span class="inline-flex rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">
                                    Rejected
                                </span>

                            @endif

                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection