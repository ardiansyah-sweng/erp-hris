@extends('layouts.app')

@section('content')

<div class="space-y-6">

    <div>
        <h1 class="text-2xl font-bold text-gray-900 tracking-tight">
            Edit Cuti & Izin
        </h1>
        <p class="mt-2 text-sm text-gray-500">
            Ubah data pengajuan cuti dan izin karyawan
        </p>
    </div>

    <div class="mt-6 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

        <div class="px-6 py-5 border-b border-gray-100">
            <h3 class="text-base font-semibold text-gray-900">
                Form Edit Pengajuan Cuti
            </h3>
        </div>

        <form action="{{ route('leave_request.update', $leaveRequest->id) }}" method="POST" class="p-6 space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    ID Karyawan
                </label>
                <input type="text" name="employee_id"
                    value="{{ old('employee_id', $leaveRequest->employee_id) }}"
                    class="block w-full rounded-xl border-0 py-2.5 px-4 text-gray-900 ring-1 ring-gray-200 focus:ring-2 focus:ring-indigo-600 sm:text-sm">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Nama Karyawan
                </label>
                <input type="text" name="employee_name"
                    value="{{ old('employee_name', $leaveRequest->employee_name) }}"
                    class="block w-full rounded-xl border-0 py-2.5 px-4 text-gray-900 ring-1 ring-gray-200 focus:ring-2 focus:ring-indigo-600 sm:text-sm">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Tanggal Mulai
                    </label>
                    <input type="date" name="start_date"
                        value="{{ old('start_date', $leaveRequest->start_date) }}"
                        class="block w-full rounded-xl border-0 py-2.5 px-4 text-gray-900 ring-1 ring-gray-200 focus:ring-2 focus:ring-indigo-600 sm:text-sm">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Tanggal Selesai
                    </label>
                    <input type="date" name="end_date"
                        value="{{ old('end_date', $leaveRequest->end_date) }}"
                        class="block w-full rounded-xl border-0 py-2.5 px-4 text-gray-900 ring-1 ring-gray-200 focus:ring-2 focus:ring-indigo-600 sm:text-sm">
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Alasan
                </label>
                <textarea name="reason" rows="4"
                    class="block w-full rounded-xl border-0 py-2.5 px-4 text-gray-900 ring-1 ring-gray-200 focus:ring-2 focus:ring-indigo-600 sm:text-sm">{{ old('reason', $leaveRequest->reason) }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Status
                </label>
                <select name="status"
                    class="block w-full rounded-xl border-0 py-2.5 px-4 text-gray-900 ring-1 ring-gray-200 focus:ring-2 focus:ring-indigo-600 sm:text-sm">
                    <option value="Pending" {{ $leaveRequest->status == 'Pending' ? 'selected' : '' }}>
                        Pending
                    </option>
                    <option value="Approved" {{ $leaveRequest->status == 'Approved' ? 'selected' : '' }}>
                        Approved
                    </option>
                    <option value="Rejected" {{ $leaveRequest->status == 'Rejected' ? 'selected' : '' }}>
                        Rejected
                    </option>
                </select>
            </div>

            <div class="flex justify-end gap-4 mt-8">

                <a href="{{ route('leave_request.index') }}"
                    class="rounded-xl bg-gray-100 px-5 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-200 transition-all">
                    Batal
                </a>

                <button type="submit"
                    class="rounded-xl bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 transition-all">
                    Simpan Perubahan
                </button>

            </div>

        </form>

    </div>

</div>

@endsection