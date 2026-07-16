@extends('layouts.app')

@section('title', 'Detail Pengumuman - ERP HRIS')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="sm:flex sm:items-center sm:justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Detail Pengumuman</h1>
            <p class="mt-1 text-sm text-gray-500">Lihat informasi lengkap pengumuman.</p>
        </div>
        <div class="mt-4 sm:mt-0 flex items-center gap-3">
             <a href="{{ route('announcement.edit', $announcement->id) }}"
                class="inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-indigo-700 transition-colors shadow-sm">
                Edit Pengumuman
            </a>
            <a href="{{ route('announcement.index') }}"
               class="inline-flex items-center gap-2 rounded-xl border border-gray-300 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50 transition-colors shadow-sm">
                <svg class="h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali
            </a>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center">
            <h3 class="text-base font-semibold text-gray-900">Informasi Pengumuman</h3>
            @if($announcement->status == 'Aktif')
                <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold">Aktif</span>
            @else
                <span class="px-3 py-1 rounded-full bg-gray-100 text-gray-700 text-xs font-semibold">Draft</span>
            @endif
        </div>

        <div class="p-6 space-y-6">
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-widest mb-1">Judul</label>
                <p class="text-lg font-bold text-gray-900">{{ $announcement->title }}</p>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-widest mb-1">Isi Pengumuman</label>
                <p class="text-sm text-gray-700 leading-relaxed whitespace-pre-line">{{ $announcement->content }}</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-4 border-t border-gray-100">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-widest mb-1">Tanggal Publikasi</label>
                    <p class="text-sm font-medium text-gray-900">{{ \Carbon\Carbon::parse($announcement->publish_date)->format('d M Y') }}</p>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-widest mb-1">Status</label>
                    <p class="text-sm font-medium text-gray-900">{{ $announcement->status }}</p>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-widest mb-1">Dibuat Pada</label>
                    <p class="text-sm font-medium text-gray-900">{{ $announcement->created_at ? \Carbon\Carbon::parse($announcement->created_at)->format('d M Y H:i') : '-' }}</p>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-widest mb-1">Terakhir Diperbarui</label>
                    <p class="text-sm font-medium text-gray-900">{{ $announcement->updated_at ? \Carbon\Carbon::parse($announcement->updated_at)->format('d M Y H:i') : '-' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
