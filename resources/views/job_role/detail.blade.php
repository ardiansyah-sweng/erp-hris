@extends('layouts.app')

@section('title', 'Detail Job Role - ERP HRIS')

@section('content')
<div class="max-w-3xl mx-auto">

    {{-- Header --}}
    <div class="sm:flex sm:items-center sm:justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Detail Job Role</h1>
            <p class="mt-1 text-sm text-gray-500">Informasi lengkap posisi pekerjaan.</p>
        </div>
        <a href="/job-roles"
           class="mt-4 sm:mt-0 inline-flex items-center gap-1.5 text-sm text-gray-600 hover:text-gray-900 bg-white border border-gray-200 hover:border-gray-300 px-4 py-2 rounded-xl transition-colors shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
    </div>

    {{-- Card --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

        {{-- Card Header --}}
        <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50">
            <h2 class="text-base font-semibold text-gray-900">{{ $jobrole->role }}</h2>
        </div>

        {{-- Card Body --}}
        <div class="px-6 py-6 grid grid-cols-1 sm:grid-cols-2 gap-6">

            {{-- Nama Role --}}
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-widest mb-1">Nama Role</p>
                <p class="text-sm font-semibold text-gray-900">{{ $jobrole->role }}</p>
            </div>

            {{-- Dibuat Pada --}}
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-widest mb-1">Dibuat Pada</p>
                <p class="text-sm text-gray-900">{{ $jobrole->created_at ? $jobrole->created_at->format('d M Y H:i') : '-' }}</p>
            </div>

            {{-- Terakhir Diperbarui --}}
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-widest mb-1">Terakhir Diperbarui</p>
                <p class="text-sm text-gray-900">{{ $jobrole->updated_at ? $jobrole->updated_at->format('d M Y H:i') : '-' }}</p>
            </div>

        </div>

        {{-- Card Footer - Aksi --}}
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50 flex gap-3">
            <a href="{{ route('jobrole.edit', $jobrole->id) }}"
               class="inline-flex items-center gap-1.5 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 px-4 py-2 rounded-xl transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                </svg>
                Edit
            </a>
            <form action="{{ route('jobrole.destroy', $jobrole->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus job role ini?')" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit"
                   class="inline-flex items-center gap-1.5 text-sm font-semibold text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 px-4 py-2 rounded-xl transition-colors border border-red-100 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    Hapus
                </button>
            </form>
        </div>

    </div>
</div>
@endsection