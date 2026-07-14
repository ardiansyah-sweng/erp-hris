@extends('layouts.app')

@section('content')

<div class="space-y-6">

    <!-- Header -->
    <div class="flex items-center justify-between">

        <div>
            <h1 class="text-2xl font-bold text-gray-900">
                Pengumuman
            </h1>

            <p class="mt-2 text-sm text-gray-500">
                Informasi dan pengumuman terbaru dari Human Resources.
            </p>
        </div>

    </div>

    <!-- List Announcement -->
    <div class="space-y-5">

        @foreach($announcements as $announcement)

        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">

            <div class="flex justify-between items-start">

                <div>

                    <h2 class="text-lg font-semibold text-gray-900">
                        {{ $announcement['title'] }}
                    </h2>

                    <p class="mt-2 text-sm text-gray-600">
                        {{ $announcement['content'] }}
                    </p>

                </div>

                @if($announcement['status'] == 'Aktif')

                    <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold">
                        Aktif
                    </span>

                @else

                    <span class="px-3 py-1 rounded-full bg-gray-100 text-gray-700 text-xs font-semibold">
                        Draft
                    </span>

                @endif

            </div>

            <div class="mt-4 flex items-center justify-between">

                <span class="text-sm text-gray-500">
                    Dipublikasikan:
                    {{ \Carbon\Carbon::parse($announcement['publish_date'])->format('d M Y') }}
                </span>

            </div>

        </div>

        @endforeach

    </div>

</div>

@endsection