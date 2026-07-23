@extends('layouts.app')

@section('title','Data Training')

@section('content')

<div class="space-y-6">

    <!-- Header -->
    <div class="flex items-center justify-between">

        <div>
            <h1 class="text-3xl font-bold text-gray-900">
                Data Training
            </h1>

            <p class="text-gray-500 mt-1">
                Kelola data pelatihan karyawan.
            </p>
        </div>

        <a href="{{ route('training.create') }}"
            class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-xl transition">
            + Tambah Training
        </a>

    </div>

    <!-- Alert -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded-xl">
            {{ session('success') }}
        </div>
    @endif

    <!-- Table -->
    <div class="bg-white rounded-2xl shadow border overflow-x-auto">

        <table class="w-full">

            <thead class="bg-gray-50">

                <tr>

                    <th class="px-6 py-4 text-left font-semibold">No</th>

                    <th class="px-6 py-4 text-left font-semibold">Judul</th>

                    <th class="px-6 py-4 text-left font-semibold">Trainer</th>

                    <th class="px-6 py-4 text-left font-semibold">Departemen</th>

                    <th class="px-6 py-4 text-left font-semibold">Tanggal</th>

                    <th class="px-6 py-4 text-left font-semibold">Lokasi</th>

                    <th class="px-6 py-4 text-left font-semibold">Status</th>

                    <th class="px-6 py-4 text-center font-semibold w-80">
                        Aksi
                    </th>

                </tr>

            </thead>

            <tbody>

                @forelse($trainings as $training)

                    <tr class="border-t hover:bg-gray-50 transition">

                        <td class="px-6 py-4">
                            {{ $loop->iteration }}
                        </td>

                        <td class="px-6 py-4 font-medium">
                            {{ $training->title }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $training->trainer }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $training->department?->name ?? '-' }}
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ \Carbon\Carbon::parse($training->training_date)->format('d M Y') }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $training->location }}
                        </td>

                        <td class="px-6 py-4">

                            @php
                                $badge = [
                                    'Scheduled' => 'bg-yellow-100 text-yellow-700',
                                    'Ongoing' => 'bg-blue-100 text-blue-700',
                                    'Completed' => 'bg-green-100 text-green-700',
                                    'Cancelled' => 'bg-red-100 text-red-700',
                                ];
                            @endphp

                            <span class="px-4 py-1 rounded-full text-sm font-medium {{ $badge[$training->status] ?? 'bg-gray-100 text-gray-700' }}">
                                {{ $training->status }}
                            </span>

                        </td>

                        <!-- AKSI -->
                        <td class="px-6 py-4">

                            <div class="flex justify-center items-center gap-2 whitespace-nowrap">

                                <!-- Detail -->
                                <a href="{{ route('training.show', $training->id) }}"
                                    class="px-4 py-2 rounded-xl
                                           bg-sky-100
                                           text-sky-700
                                           hover:bg-sky-200
                                           font-medium
                                           transition">

                                    Detail

                                </a>

                                <!-- Edit -->
                                <a href="{{ route('training.edit', $training->id) }}"
                                    class="px-4 py-2 rounded-xl
                                           bg-indigo-100
                                           text-indigo-700
                                           hover:bg-indigo-200
                                           font-medium
                                           transition">

                                    Edit

                                </a>

                                <!-- Hapus -->
                                <form action="{{ route('training.destroy', $training->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus training ini?')">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                        class="px-4 py-2 rounded-xl
                                               bg-red-100
                                               text-red-700
                                               hover:bg-red-200
                                               font-medium
                                               transition">

                                        Hapus

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="8"
                            class="text-center py-10 text-gray-500">

                            Belum ada data training.

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection