@extends('layouts.app')

@section('title', 'Tambah Job Role - ERP HRIS')

@section('content')

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 tracking-tight">
            Tambah Job Role
        </h1>
        <p class="mt-2 text-sm text-gray-500">
            Tambahkan posisi pekerjaan baru.
        </p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

        <div class="px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-indigo-50 to-white">
            <h2 class="text-lg font-semibold text-gray-900">
                Form Tambah Job Role
            </h2>
            <p class="mt-1 text-sm text-gray-500">
                Lengkapi informasi job role di bawah ini.
            </p>
        </div>

        <form action="{{ route('jobrole.store') }}" method="POST" class="p-6">
            @csrf

            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Nama Role
                </label>
                <input
                    type="text"
                    name="name"
                    placeholder="Contoh: Software Engineer"
                    class="w-full px-4 py-3 rounded-xl border-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                >
                <p class="mt-2 text-xs text-gray-400">
                    Masukkan nama posisi pekerjaan.
                </p>
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
                        <option value="{{ $dept->id }}">{{ $dept->name }}</option>
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
                        <option value="{{ $lvl->id }}">{{ $lvl->name }}</option>
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
                    <option value="Active">Aktif</option>
                    <option value="Cuti">Cuti</option>
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
                    Simpan Job Role
                </button>
            </div>

        </form>

    </div>

</div>

@endsection
