@extends('layouts.app')

@section('title', 'Edit Job Role - ERP HRIS')

@section('content')

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 tracking-tight">
            Edit Job Role
        </h1>
        <p class="mt-2 text-sm text-gray-500">
            Perbarui informasi posisi pekerjaan.
        </p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

        <div class="px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-indigo-50 to-white">
            <h2 class="text-lg font-semibold text-gray-900">
                Form Edit Job Role
            </h2>
            <p class="mt-1 text-sm text-gray-500">
                Ubah informasi job role di bawah ini.
            </p>
        </div>

        <form action="{{ route('jobrole.update', $jobrole->id) }}" method="POST" class="p-6">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Nama Role
                </label>
                <input
                    type="text"
                    name="name"
                    value="{{ old('name', $jobrole->role) }}"
                    placeholder="Contoh: Software Engineer"
                    class="w-full px-4 py-3 rounded-xl border-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                >
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Departemen
                </label>
                <select
                    name="department_id"
                    class="w-full rounded-xl border-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                >
                    <option value="">Pilih Departemen</option>
                    @foreach($departments as $dept)
                        <option value="{{ $dept->id }}" {{ old('department_id', $jobrole->department_id) == $dept->id ? 'selected' : '' }}>
                            {{ $dept->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Level
                </label>
                <select
                    name="level_id"
                    class="w-full rounded-xl border-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                >
                    <option value="">Pilih Level</option>
                    @foreach($levels as $lvl)
                        <option value="{{ $lvl->id }}" {{ old('level_id', $jobrole->level_id) == $lvl->id ? 'selected' : '' }}>
                            {{ $lvl->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-8">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Status
                </label>
                <select
                    name="status"
                    class="w-full rounded-xl border-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                >
                    <option value="Active" {{ old('status', $jobrole->status) == 'Active' ? 'selected' : '' }}>Aktif</option>
                    <option value="Cuti" {{ old('status', $jobrole->status) == 'Cuti' ? 'selected' : '' }}>Cuti</option>
                </select>
            </div>

            <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-100">
                <a href="{{ route('jobrole.index') }}"
                   class="rounded-xl border border-gray-200 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50 transition">
                    Kembali
                </a>
                <button
                    type="submit"
                    class="rounded-xl bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 transition-all duration-200"
                >
                    Update Job Role
                </button>
            </div>

        </form>

    </div>

</div>

@endsection
