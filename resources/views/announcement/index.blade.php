@extends('layouts.app')

@section('title', 'Pengumuman - ERP HRIS')

@section('content')
    @if (session('success'))
        <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">
            {{ session('success') }}
        </div>
    @endif

    <div class="sm:flex sm:items-center sm:justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Pengumuman</h1>
            <p class="mt-1 text-sm text-gray-500">
                Informasi dan pengumuman terbaru dari Human Resources.
            </p>
        </div>
        <div class="mt-4 sm:mt-0">
            <a href="{{ route('announcement.create') }}"
               class="inline-flex items-center justify-center rounded-xl bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm shadow-indigo-200 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all duration-200 hover:-translate-y-0.5 transform">
                <svg class="mr-2 -ml-0.5 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Pengumuman
            </a>
        </div>
    </div>

    <div class="space-y-5">
        @forelse($announcements as $announcement)
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 hover:shadow-md transition-shadow duration-300">
                <div class="flex justify-between items-start">
                    <div class="flex-1 min-w-0">
                        <h2 class="text-lg font-semibold text-gray-900">{{ $announcement->title }}</h2>
                        <p class="mt-2 text-sm text-gray-600">{{ $announcement->content }}</p>
                    </div>
                    <div class="flex items-center gap-2 ml-4 flex-shrink-0">
                        @if($announcement->status == 'Aktif')
                            <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold">Aktif</span>
                        @else
                            <span class="px-3 py-1 rounded-full bg-gray-100 text-gray-700 text-xs font-semibold">Draft</span>
                        @endif
                    </div>
                </div>

                <div class="mt-4 flex items-center justify-between">
                    <span class="text-sm text-gray-500">
                        Dipublikasikan: {{ \Carbon\Carbon::parse($announcement->publish_date)->format('d M Y') }}
                    </span>
                    <div class="flex items-center gap-2">
                        <form action="{{ route('announcement.send-reminder', $announcement->id) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit"
                                    class="text-emerald-600 hover:text-emerald-900 bg-emerald-50 hover:bg-emerald-100 px-3 py-1.5 rounded-lg text-xs font-semibold flex items-center gap-1 transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                Kirim Email
                            </button>
                        </form>
                        <a href="{{ route('announcement.show', $announcement->id) }}"
                           class="text-sky-600 hover:text-sky-900 bg-sky-50 hover:bg-sky-100 px-3 py-1.5 rounded-lg text-xs font-semibold flex items-center gap-1 transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            Detail
                        </a>
                        <a href="{{ route('announcement.edit', $announcement->id) }}"
                           class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 px-3 py-1.5 rounded-lg text-xs font-semibold flex items-center gap-1 transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                            </svg>
                            Edit
                        </a>
                        <button type="button"
                                onclick="confirmDelete({{ $announcement->id }}, '{{ $announcement->title }}')"
                                class="text-rose-600 hover:text-rose-900 bg-rose-50 hover:bg-rose-100 px-3 py-1.5 rounded-lg text-xs font-semibold flex items-center gap-1 transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Hapus
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-16 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-50 mb-4">
                    <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                    </svg>
                </div>
                <h3 class="text-sm font-semibold text-gray-900">Belum ada pengumuman</h3>
                <p class="mt-1 text-sm text-gray-500">Buat pengumuman pertama untuk tim Anda.</p>
                <div class="mt-6">
                    <a href="{{ route('announcement.create') }}"
                       class="inline-flex items-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700">
                        Tambah Pengumuman
                    </a>
                </div>
            </div>
        @endforelse
    </div>
<form id="deleteForm" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>

{{-- Modal Hapus --}}
<div id="deleteModal" class="fixed inset-0 z-50 hidden bg-black/40 flex items-center justify-center p-4" onclick="closeDeleteModal(event)">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden" onclick="event.stopPropagation()">
        <div class="px-6 pt-6 pb-2 text-center">
            <div class="mx-auto w-14 h-14 rounded-full bg-red-100 flex items-center justify-center mb-4">
                <svg class="w-7 h-7 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4.5c-.77-.833-2.694-.833-3.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                </svg>
            </div>
            <h3 class="text-lg font-bold text-gray-900">Hapus Pengumuman</h3>
            <p class="mt-2 text-sm text-gray-500">
                Apakah Anda yakin ingin menghapus pengumuman <strong id="deleteTitle"></strong>?
            </p>
            <p class="mt-1 text-xs text-rose-500">Tindakan ini tidak dapat dikembalikan.</p>
        </div>
        <div class="px-6 py-4 bg-gray-50 border-t mt-4 flex justify-end gap-3">
            <button onclick="closeDeleteModal()"
                    class="rounded-xl border border-gray-300 px-5 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50 transition-all">
                Batal
            </button>
            <button onclick="submitDelete()"
                    class="rounded-xl bg-red-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-red-700 transition-all">
                Ya, Hapus
            </button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function confirmDelete(id, title) {
        document.getElementById('deleteForm').action = '/announcement/' + id;
        document.getElementById('deleteTitle').textContent = title;
        document.getElementById('deleteModal').classList.remove('hidden');
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
    }

    function submitDelete() {
        document.getElementById('deleteForm').submit();
    }
</script>
@endpush