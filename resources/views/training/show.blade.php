@extends('layouts.app')

@section('title','Detail Training')

@section('content')

<div class="max-w-4xl mx-auto">

    <div class="bg-white rounded-2xl shadow border">

        <div class="border-b px-8 py-6">

            <h1 class="text-2xl font-bold">
                Detail Training
            </h1>

            <p class="text-gray-500 mt-1">
                Informasi lengkap pelatihan.
            </p>

        </div>

        <div class="p-8">

            <div class="grid grid-cols-2 gap-8">

                <div>

                    <label class="text-gray-500 text-sm">
                        Judul Training
                    </label>

                    <p class="font-semibold mt-1">
                        {{ $training->title }}
                    </p>

                </div>

                <div>

                    <label class="text-gray-500 text-sm">
                        Trainer
                    </label>

                    <p class="font-semibold mt-1">
                        {{ $training->trainer }}
                    </p>

                </div>

                <div>

                    <label class="text-gray-500 text-sm">
                        Departemen
                    </label>

                    <p class="font-semibold mt-1">
                        {{ $training->department?->name ?? '-' }}
                    </p>

                </div>

                <div>

                    <label class="text-gray-500 text-sm">
                        Tanggal
                    </label>

                    <p class="font-semibold mt-1">
                        {{ \Carbon\Carbon::parse($training->training_date)->format('d F Y') }}
                    </p>

                </div>

                <div>

                    <label class="text-gray-500 text-sm">
                        Lokasi
                    </label>

                    <p class="font-semibold mt-1">
                        {{ $training->location }}
                    </p>

                </div>

                <div>

                    <label class="text-gray-500 text-sm">
                        Status
                    </label>

                    @php
                        $badge = [
                            'Scheduled'=>'bg-yellow-100 text-yellow-700',
                            'Ongoing'=>'bg-blue-100 text-blue-700',
                            'Completed'=>'bg-green-100 text-green-700',
                            'Cancelled'=>'bg-red-100 text-red-700',
                        ];
                    @endphp

                    <span class="inline-block px-3 py-1 rounded-full text-sm {{ $badge[$training->status] ?? 'bg-gray-100 text-gray-700' }}">
                        {{ $training->status }}
                    </span>

                </div>

            </div>

            <div class="mt-8">

                <label class="text-gray-500 text-sm">
                    Deskripsi
                </label>

                <div class="mt-2 border rounded-xl p-4 bg-gray-50">

                    {{ $training->description ?: '-' }}

                </div>

            </div>

        </div>

        <div class="border-t px-8 py-5 flex justify-end gap-3">

            <a href="{{ route('training.index') }}"
                class="px-5 py-2 rounded-xl border hover:bg-gray-100">

                Kembali

            </a>

            <a href="{{ route('training.edit',$training->id) }}"
                class="px-5 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white">

                Edit

            </a>

        </div>

    </div>

</div>

@endsection