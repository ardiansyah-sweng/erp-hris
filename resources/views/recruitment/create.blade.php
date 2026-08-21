@extends('layouts.app')

@section('title', 'Tambah Pelamar')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-lg shadow p-6">
        <h1 class="text-2xl font-semibold mb-4">Tambah Pelamar</h1>

        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-50 border border-red-100 text-red-700 rounded">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('recruitment.store') }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div>
                    <label class="block text-sm font-medium text-gray-700">Nama Pelamar</label>
                    <input
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        class="mt-1 block w-full rounded-md border-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-200"
                        required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        class="mt-1 block w-full rounded-md border-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-200"
                        required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Nomor HP</label>
                    <input
                        type="text"
                        name="phone_number"
                        value="{{ old('phone_number') }}"
                        class="mt-1 block w-full rounded-md border-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-200"
                        required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Job Role</label>
                    <select
                        name="role_id"
                        class="mt-1 block w-full rounded-md border-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-200"
                        required>

                        <option value="">-- Pilih Job Role --</option>

                        @foreach($jobroles as $role)
                            <option
                                value="{{ $role->id }}"
                                {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                {{ $role->role }}
                            </option>
                        @endforeach

                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Tanggal Apply</label>
                    <input
                        type="date"
                        name="apply_date"
                        value="{{ old('apply_date') }}"
                        class="mt-1 block w-full rounded-md border-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-200"
                        required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Status</label>
                    <select
                        name="status"
                        class="mt-1 block w-full rounded-md border-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-200">

                        <option value="Screening">Screening</option>
                        <option value="Interview">Interview</option>
                        <option value="Accepted">Accepted</option>
                        <option value="Rejected">Rejected</option>

                    </select>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Upload CV (PDF)</label>
                    <input
                        type="file"
                        name="cv"
                        accept=".pdf"
                        class="mt-1 block w-full rounded-md border-gray-200 shadow-sm">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Catatan</label>
                    <textarea
                        name="notes"
                        rows="4"
                        class="mt-1 block w-full rounded-md border-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-200">{{ old('notes') }}</textarea>
                </div>

            </div>

            <div class="mt-6 flex items-center gap-3">

                <button
                    type="submit"
                    class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">

                    Simpan Pelamar

                </button>

                <a href="{{ route('recruitment.index') }}"
                   class="px-4 py-2 border border-gray-200 rounded-md text-gray-700">

                    Batal

                </a>

            </div>

        </form>

    </div>
</div>
@endsection
