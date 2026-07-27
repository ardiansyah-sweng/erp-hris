@extends('layouts.app')

@section('title', 'Peserta Training - ' . $training->title)

@section('content')

    @if(session('success'))
        <div class="mb-6 rounded-xl bg-emerald-50 border border-emerald-200 px-5 py-4 text-sm font-semibold text-emerald-700">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-6 rounded-xl bg-red-50 border border-red-200 px-5 py-4 text-sm font-semibold text-red-700">
            {{ $errors->first() }}
        </div>
    @endif

    <!-- Header -->
    <div class="sm:flex sm:items-center sm:justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Peserta Training</h1>
            <p class="mt-1 text-sm text-gray-500">
                {{ $training->title }} — {{ \Carbon\Carbon::parse($training->training_date)->format('d F Y') }}
            </p>
        </div>
        <div class="mt-4 sm:mt-0">
            <a href="{{ route('training.show', $training->id) }}"
               class="inline-flex items-center rounded-xl border border-gray-200 bg-white px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50">
                ← Kembali ke Detail Training
            </a>
        </div>
    </div>

    <!-- Form Tambah Peserta -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-8">
        <h3 class="text-base font-semibold text-gray-900 mb-4">Tambah Peserta</h3>

        <form method="POST" action="{{ route('training.participants.store', $training->id) }}" class="flex gap-3">
            @csrf
            <select name="employee_id" required
                    class="flex-1 rounded-xl border-0 py-2.5 px-3 text-gray-900 ring-1 ring-inset ring-gray-200 focus:ring-2 focus:ring-indigo-600 text-sm">
                <option value="">-- Pilih Karyawan --</option>
                @foreach($availableEmployees as $employee)
                    <option value="{{ $employee->id }}">{{ $employee->name }} ({{ $employee->employee_code }})</option>
                @endforeach
            </select>
            <button type="submit"
                    class="rounded-xl bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-indigo-700">
                Daftarkan
            </button>
        </form>

        @if($availableEmployees->isEmpty())
            <p class="text-sm text-gray-500 mt-3">Semua karyawan sudah terdaftar di training ini.</p>
        @endif
    </div>

    <!-- Tabel Peserta -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100">
            <h3 class="text-base font-semibold text-gray-900">Daftar Peserta ({{ count($participants) }})</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50/50">
                    <tr>
                        <th class="py-4 pl-6 pr-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-widest">No</th>
                        <th class="px-3 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-widest">Nama Karyawan</th>
                        <th class="px-3 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-widest">Status Kehadiran</th>
                        <th class="py-4 pl-3 pr-6 text-right text-xs font-semibold text-gray-500 uppercase tracking-widest">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @forelse($participants as $participant)
                        <tr class="hover:bg-indigo-50/40 transition-colors">
                            <td class="whitespace-nowrap py-4 pl-6 pr-3 text-sm font-medium text-gray-900">{{ $loop->iteration }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-900">{{ $participant->employee->name }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm">
                                @if($participant->attendance_status == 'Attended')
                                    <span class="inline-flex items-center rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700 ring-1 ring-inset ring-emerald-600/20">Hadir</span>
                                @elseif($participant->attendance_status == 'Absent')
                                    <span class="inline-flex items-center rounded-full bg-red-50 px-2.5 py-1 text-xs font-semibold text-red-700 ring-1 ring-inset ring-red-600/20">Tidak Hadir</span>
                                @else
                                    <span class="inline-flex items-center rounded-full bg-amber-50 px-2.5 py-1 text-xs font-semibold text-amber-700 ring-1 ring-inset ring-amber-600/20">Terdaftar</span>
                                @endif
                            </td>
                            <td class="whitespace-nowrap py-4 pl-3 pr-6 text-right text-sm">
                                <div class="flex justify-end gap-2">
                                    <form method="POST" action="{{ route('training.participants.update', $participant->id) }}">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="attendance_status" value="Attended">
                                        <button type="submit" class="text-emerald-600 hover:text-emerald-900 bg-emerald-50 hover:bg-emerald-100 px-3 py-1.5 rounded-lg text-xs font-semibold">
                                            Hadir
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('training.participants.update', $participant->id) }}">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="attendance_status" value="Absent">
                                        <button type="submit" class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg text-xs font-semibold">
                                            Tidak Hadir
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('training.participants.destroy', $participant->id) }}"
                                          onsubmit="return confirm('Hapus peserta ini dari training?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-gray-500 hover:text-gray-900 bg-gray-50 hover:bg-gray-100 px-3 py-1.5 rounded-lg text-xs font-semibold">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-16 text-center text-sm text-gray-500">
                                Belum ada peserta terdaftar untuk training ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection