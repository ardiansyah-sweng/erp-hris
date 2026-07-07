<x-app-layout title="Evaluasi Kinerja Karyawan">
    <div class="space-y-8 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="sm:flex sm:items-center sm:justify-between mb-0">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Evaluasi Kinerja Karyawan</h1>
                <p class="mt-1 text-sm text-gray-500">Catat, tinjau, dan kelola evaluasi kinerja karyawan secara sederhana.</p>
            </div>

            <a href="{{ route('evaluations.create') }}"
               class="inline-flex items-center justify-center gap-2 rounded-xl bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Tambah Evaluasi
            </a>
        </div>

        @if (session('success'))
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">
                {{ session('success') }}
            </div>
        @endif

        {{-- Card ringkasan, konsisten dengan halaman Job Role --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 flex items-center gap-4">
                <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Total Evaluasi</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $evaluations->count() }}</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 flex items-center gap-4">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Rata-rata Skor</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($evaluations->avg('score'), 1) }}</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 flex items-center gap-4">
                <div class="w-10 h-10 rounded-xl bg-rose-50 flex items-center justify-center">
                    <svg class="w-5 h-5 text-rose-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Skor Rendah (≤2)</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $evaluations->where('score', '<=', 2)->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            {{-- Bagian pencarian sudah dihapus di bawah ini --}}
            <div class="px-6 py-5 border-b border-gray-50">
                <h2 class="text-base font-semibold text-gray-900">Daftar Evaluasi</h2>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50/50">
                        <tr>
                            <th class="py-4 pl-6 pr-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-widest">Karyawan</th>
                            <th class="px-3 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-widest">Tanggal</th>
                            <th class="px-3 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-widest">Skor</th>
                            <th class="px-3 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-widest">Penilai</th>
                            <th class="px-3 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-widest">Feedback</th>
                            <th class="py-4 pl-3 pr-6 text-right text-xs font-semibold text-gray-500 uppercase tracking-widest">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @forelse($evaluations as $evaluation)
                            <tr class="hover:bg-indigo-50/40 transition-colors duration-150">
                                <td class="whitespace-nowrap px-3 py-4 text-sm font-semibold text-gray-900">
                                    {{ $evaluation->employee->name ?? '-' }}
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-600">
                                    {{ \Carbon\Carbon::parse($evaluation->evaluation_date)->format('d-m-Y') }}
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm">
                                    @php
                                        $score = $evaluation->score;
                                        // Skala skor 1-5. Sesuaikan angka batas ini kalau skala kamu berbeda.
                                        $badgeColor = $score >= 4
                                            ? 'bg-emerald-50 text-emerald-700'
                                            : ($score >= 3 ? 'bg-amber-50 text-amber-700' : 'bg-rose-50 text-rose-700');
                                    @endphp
                                    <span class="inline-flex items-center gap-1.5 rounded-full {{ $badgeColor }} px-2.5 py-1 text-xs font-semibold">
                                        <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                        {{ $score }}
                                    </span>
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-600">
                                    {{ $evaluation->evaluator->name ?? '-' }}
                                </td>
                                <td class="max-w-xs px-3 py-4 text-sm text-gray-600 truncate">
                                    {{ $evaluation->feedback ?? '-' }}
                                </td>
                                <td class="whitespace-nowrap py-4 pl-3 pr-6 text-right text-sm">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('evaluations.edit', $evaluation->id) }}"
                                           class="inline-flex items-center gap-1 rounded-lg bg-indigo-50 px-3 py-1.5 text-indigo-600 hover:bg-indigo-100">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z" />
                                            </svg>
                                            Edit
                                        </a>
                                        <form action="{{ route('evaluations.destroy', $evaluation->id) }}" method="POST" onsubmit="return confirm('Hapus data evaluasi ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="inline-flex items-center gap-1 rounded-lg bg-rose-50 px-3 py-1.5 text-rose-600 hover:bg-rose-100">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                </svg>
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-16 text-center">
                                    <h3 class="text-sm font-semibold text-gray-900">Belum ada data evaluasi</h3>
                                    <p class="mt-1 text-sm text-gray-500">Mulai dengan menambahkan evaluasi kinerja pertama.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>