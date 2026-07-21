@extends('layouts.app')

@section('content')

<div class="space-y-6">

    <!-- Header -->
    <div class="sm:flex sm:items-center sm:justify-between">

        <div>
            <h1 class="text-2xl font-bold text-gray-900">
                Detail Pengajuan Cuti
            </h1>

            <p class="mt-1 text-sm text-gray-500">
                Informasi lengkap pengajuan cuti karyawan.
            </p>
        </div>

        <a href="{{ route('leave_request.index') }}"
           class="inline-flex items-center rounded-xl border border-gray-300 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50">

            Kembali
        </a>

    </div>

    <!-- Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100">

        <div class="px-6 py-5 border-b border-gray-100">

            <h3 class="font-semibold text-gray-900">
                Informasi Cuti
            </h3>

        </div>

        <div class="p-6">

            <dl class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div>
                    <dt class="text-sm text-gray-500">ID Karyawan</dt>
                    <dd class="mt-1 font-medium text-gray-900">
                        {{ $leaveRequest->employee_id }}
                    </dd>
                </div>

                <div>
                    <dt class="text-sm text-gray-500">Nama Karyawan</dt>
                    <dd class="mt-1 font-medium text-gray-900">
                        {{ $leaveRequest->employee_name }}
                    </dd>
                </div>

                <div>
                    <dt class="text-sm text-gray-500">Tanggal Mulai</dt>
                    <dd class="mt-1 font-medium text-gray-900">
                        {{ $leaveRequest->start_date }}
                    </dd>
                </div>

                <div>
                    <dt class="text-sm text-gray-500">Tanggal Selesai</dt>
                    <dd class="mt-1 font-medium text-gray-900">
                        {{ $leaveRequest->end_date }}
                    </dd>
                </div>

                <div>
                    <dt class="text-sm text-gray-500">Total Hari</dt>
                    <dd class="mt-1 font-medium text-gray-900">
                        {{ $leaveRequest->total_days }} hari
                    </dd>
                </div>

                <div>
                    <dt class="text-sm text-gray-500">Sisa Cuti Tahunan</dt>
                    <dd class="mt-1">
                        @php
                            $employee = \App\Models\Employee::where('employee_code', $leaveRequest->employee_id)->first();
                        @endphp
                        @if($employee)
                            <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold {{ $employee->remaining_leave <= 3 ? 'bg-red-50 text-red-700' : 'bg-emerald-50 text-emerald-700' }}">
                                {{ $employee->remaining_leave }} hari
                            </span>
                        @else
                            <span class="text-gray-400">-</span>
                        @endif
                    </dd>
                </div>

                <div>
                    <dt class="text-sm text-gray-500">Status</dt>

                    <dd class="mt-1">

                        @if($leaveRequest->status == 'Approved')

                            <span class="inline-flex rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                                Approved
                            </span>

                        @elseif($leaveRequest->status == 'Pending')

                            <span class="inline-flex rounded-full bg-yellow-100 px-3 py-1 text-xs font-semibold text-yellow-700">
                                Pending
                            </span>

                        @else

                            <span class="inline-flex rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">
                                Rejected
                            </span>

                        @endif

                    </dd>

                </div>

                <div>
                    <dt class="text-sm text-gray-500">Tanggal Pengajuan</dt>
                    <dd class="mt-1 font-medium text-gray-900">
                        {{ $leaveRequest->created_at }}
                    </dd>
                </div>

                <div class="md:col-span-2">

                    <dt class="text-sm text-gray-500">
                        Alasan
                    </dt>

                    <dd class="mt-1 text-gray-900">
                        {{ $leaveRequest->reason }}
                    </dd>

                </div>

            </dl>

        </div>

    </div>

</div>

@endsection
