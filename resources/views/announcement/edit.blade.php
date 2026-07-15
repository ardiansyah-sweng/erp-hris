@extends('layouts.app')

@section('title', 'Edit Pengumuman - ERP HRIS')

@section('content')
<div class="sm:flex sm:items-center sm:justify-between mb-8">
    <div>
        <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Edit Pengumuman</h1>
        <p class="mt-1 text-sm text-gray-500">Perbarui informasi pengumuman yang sudah ada.</p>
    </div>
    <div class="mt-4 sm:mt-0">
        <a href="{{ route('announcement.index') }}"
           class="inline-flex items-center rounded-xl border border-gray-300 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50 transition-all">
            <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali
        </a>
    </div>
</div>

@if ($errors->any())
    <div class="mb-6 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
        <p class="font-semibold mb-1">Periksa kembali isian berikut:</p>
        <ul class="list-disc list-inside space-y-0.5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-100">
        <h3 class="text-base font-semibold text-gray-900">Form Edit Pengumuman</h3>
    </div>

    <form action="{{ route('announcement.update', $announcement->id) }}" method="POST" class="p-6 space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Judul Pengumuman</label>
            <input type="text" name="title" value="{{ old('title', $announcement->title) }}" required
                   placeholder="Masukkan judul pengumuman"
                   class="block w-full rounded-xl border-0 py-3 px-4 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-indigo-600 sm:text-sm @error('title') ring-rose-400 @enderror">
            @error('title') <p class="mt-1 text-sm text-rose-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Konten Pengumuman</label>
            <textarea name="content" rows="6" required
                      placeholder="Tulis isi pengumuman di sini..."
                      class="block w-full rounded-xl border-0 py-3 px-4 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-indigo-600 sm:text-sm @error('content') ring-rose-400 @enderror">{{ old('content', $announcement->content) }}</textarea>
            @error('content') <p class="mt-1 text-sm text-rose-600">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Publikasi</label>
                <input type="date" name="publish_date"
                       value="{{ old('publish_date', \Carbon\Carbon::parse($announcement->publish_date)->format('Y-m-d')) }}" required
                       class="block w-full rounded-xl border-0 py-3 px-4 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm @error('publish_date') ring-rose-400 @enderror">
                @error('publish_date') <p class="mt-1 text-sm text-rose-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select name="status" required
                        class="block w-full rounded-xl border-0 py-3 px-4 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm bg-white @error('status') ring-rose-400 @enderror">
                    <option value="Aktif" @selected(old('status', $announcement->status) == 'Aktif')>Aktif</option>
                    <option value="Draft" @selected(old('status', $announcement->status) == 'Draft')>Draft</option>
                </select>
                @error('status') <p class="mt-1 text-sm text-rose-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="flex justify-end gap-3 pt-5 border-t border-gray-100">
            <a href="{{ route('announcement.index') }}"
               class="rounded-xl border border-gray-300 px-5 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50 transition-all">
                Batal
            </a>
            <button type="submit"
                    class="inline-flex items-center rounded-xl bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 transition-all">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
