@extends('layouts.app')

@section('title', 'Jadwal Shift Saya - ERP HRIS')

@section('content')
<div class="mb-6">
    <a href="{{ route('self-service.dashboard') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-800">&larr; Kembali ke Portal</a>
    <h1 class="text-2xl font-bold text-gray-900 tracking-tight mt-2">Jadwal Shift Saya</h1>
    <p class="mt-1 text-sm text-gray-500">Jadwal kerja Anda bulan {{ DateTime::createFromFormat('!m', $scheduleData['month'])->format('F') }} {{ $scheduleData['year'] }}.</p>
</div>

<!-- Navigation Bulan -->
<div class="mb-6 flex items-center gap-4 bg-white rounded-2xl border border-gray-100 shadow-sm p-4">
    @php
        $prevMonth = $scheduleData['month'] - 1;
        $prevYear = $scheduleData['year'];
        if ($prevMonth < 1) { $prevMonth = 12; $prevYear--; }
        $nextMonth = $scheduleData['month'] + 1;
        $nextYear = $scheduleData['year'];
        if ($nextMonth > 12) { $nextMonth = 1; $nextYear++; }
    @endphp
    <a href="{{ route('self-service.schedule', ['month' => $prevMonth, 'year' => $prevYear]) }}" class="px-3 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl text-sm font-medium transition">&larr; Sebelumnya</a>
    <span class="flex-1 text-center text-base font-bold text-gray-900">
        {{ DateTime::createFromFormat('!m', $scheduleData['month'])->format('F') }} {{ $scheduleData['year'] }}
    </span>
    <a href="{{ route('self-service.schedule', ['month' => $nextMonth, 'year' => $nextYear]) }}" class="px-3 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl text-sm font-medium transition">Berikutnya &rarr;</a>
</div>

<!-- Shift Info -->
@if($scheduleData['current_shift'])
<div class="mb-6 bg-indigo-50 rounded-2xl border border-indigo-100 p-4 flex items-center gap-3">
    <div class="p-2 bg-indigo-100 text-indigo-600 rounded-xl">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
    </div>
    <div>
        <span class="text-sm font-bold text-indigo-900">Shift Aktif: {{ $scheduleData['current_shift']->name }}</span>
        <span class="text-xs text-indigo-600 ml-2">({{ $scheduleData['current_shift']->start_time }} - {{ $scheduleData['current_shift']->end_time }})</span>
    </div>
</div>
@endif

<!-- Kalender Grid -->
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="grid grid-cols-7 text-center bg-gray-50 border-b border-gray-100">
        @foreach(['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'] as $dayName)
        <div class="py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ $dayName }}</div>
        @endforeach
    </div>
    <div class="grid grid-cols-7">
        @php
            $firstDay = date('N', strtotime($scheduleData['year'] . '-' . str_pad($scheduleData['month'], 2, '0', STR_PAD_LEFT) . '-01'));
        @endphp

        {{-- Empty cells before first day --}}
        @for($i = 1; $i < $firstDay; $i++)
            <div class="min-h-[80px] border-b border-r border-gray-50 bg-gray-50/30"></div>
        @endfor

        @foreach($scheduleData['schedule'] as $day)
        <div class="min-h-[80px] border-b border-r border-gray-50 p-2 {{ $day['is_weekend'] ? 'bg-gray-50/50' : '' }} {{ $day['date'] == date('Y-m-d') ? 'bg-indigo-50/50 ring-2 ring-inset ring-indigo-200' : '' }}">
            <div class="text-xs font-bold {{ $day['date'] == date('Y-m-d') ? 'text-indigo-600' : ($day['is_weekend'] ? 'text-gray-400' : 'text-gray-700') }}">
                {{ date('j', strtotime($day['date'])) }}
            </div>
            @if($day['shift'] && !$day['is_weekend'])
                <div class="mt-1 px-1.5 py-0.5 bg-indigo-100 text-indigo-700 rounded text-[10px] font-semibold truncate">
                    {{ $day['shift']->name }}
                </div>
                <div class="text-[10px] text-gray-500 mt-0.5">
                    {{ $day['shift']->start_time }} - {{ $day['shift']->end_time }}
                </div>
            @elseif($day['is_weekend'])
                <div class="mt-1 px-1.5 py-0.5 bg-gray-100 text-gray-500 rounded text-[10px] font-medium">
                    Libur
                </div>
            @endif
        </div>
        @endforeach
    </div>
</div>
@endsection
