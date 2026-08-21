@extends('layouts.app')

@section('title', 'Recruitment - ERP HRIS')

@section('content')

@php
    $total = $recruitments->count();
    $screening = $recruitments->where('status','Screening')->count();
    $interview = $recruitments->where('status','Interview')->count();
    $accepted = $recruitments->where('status','Accepted')->count();
    $rejected = $recruitments->where('status','Rejected')->count();
@endphp

<div class="sm:flex sm:items-center sm:justify-between mb-8">
    <div>
        <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Recruitment</h1>
        <p class="mt-1 text-sm text-gray-500">Kelola seluruh data pelamar perusahaan.</p>
    </div>

    <div class="mt-4 sm:mt-0">
        <a href="{{ route('recruitment.create') }}" class="inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Pelamar
        </a>
    </div>
</div>

@if(session('success'))
    <div class="mb-6 rounded-xl bg-emerald-50 border border-emerald-200 px-4 py-3 text-sm font-medium text-emerald-700">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="mb-6 rounded-xl bg-red-50 border border-red-200 px-4 py-3 text-sm font-medium text-red-700">
        {{ session('error') }}
    </div>
@endif

@if($errors->any())
    <div class="mb-6 rounded-xl bg-red-50 border border-red-200 px-4 py-3 text-sm font-medium text-red-700">
        {{ $errors->first() }}
    </div>
@endif

<!-- Stat Cards -->
<div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-5 mb-8">

    <div class="bg-white overflow-hidden rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col transition-transform hover:-translate-y-1 duration-300">
        <div class="flex items-center mb-2">
            <div class="p-2.5 rounded-xl bg-indigo-50 text-indigo-600 mr-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <p class="text-sm font-medium text-gray-500">Total Applicant</p>
        </div>
        <div class="flex items-baseline gap-2">
            <p class="text-3xl font-bold text-gray-900">{{ $total }}</p>
            <span class="text-sm text-indigo-600 font-medium">pelamar</span>
        </div>
    </div>

    <div class="bg-white overflow-hidden rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col transition-transform hover:-translate-y-1 duration-300">
        <div class="flex items-center mb-2">
            <div class="p-2.5 rounded-xl bg-yellow-50 text-yellow-600 mr-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <p class="text-sm font-medium text-gray-500">Screening</p>
        </div>
        <div class="flex items-baseline gap-2">
            <p class="text-3xl font-bold text-gray-900">{{ $screening }}</p>
            <span class="text-sm text-yellow-600 font-medium">pelamar</span>
        </div>
    </div>

    <div class="bg-white overflow-hidden rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col transition-transform hover:-translate-y-1 duration-300">
        <div class="flex items-center mb-2">
            <div class="p-2.5 rounded-xl bg-blue-50 text-blue-600 mr-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                </svg>
            </div>
            <p class="text-sm font-medium text-gray-500">Interview</p>
        </div>
        <div class="flex items-baseline gap-2">
            <p class="text-3xl font-bold text-gray-900">{{ $interview }}</p>
            <span class="text-sm text-blue-600 font-medium">pelamar</span>
        </div>
    </div>

    <div class="bg-white overflow-hidden rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col transition-transform hover:-translate-y-1 duration-300">
        <div class="flex items-center mb-2">
            <div class="p-2.5 rounded-xl bg-emerald-50 text-emerald-600 mr-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <p class="text-sm font-medium text-gray-500">Accepted</p>
        </div>
        <div class="flex items-baseline gap-2">
            <p class="text-3xl font-bold text-gray-900">{{ $accepted }}</p>
            <span class="text-sm text-emerald-600 font-medium">pelamar</span>
        </div>
    </div>

    <div class="bg-white overflow-hidden rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col transition-transform hover:-translate-y-1 duration-300">
        <div class="flex items-center mb-2">
            <div class="p-2.5 rounded-xl bg-red-50 text-red-600 mr-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <p class="text-sm font-medium text-gray-500">Rejected</p>
        </div>
        <div class="flex items-baseline gap-2">
            <p class="text-3xl font-bold text-gray-900">{{ $rejected }}</p>
            <span class="text-sm text-red-600 font-medium">pelamar</span>
        </div>
    </div>

</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow duration-300">

    <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center">
        <h3 class="text-base font-semibold text-gray-900">Daftar Pelamar</h3>

        <div class="relative" id="searchWrapper">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <input
                type="text"
                id="searchInput"
                autocomplete="off"
                class="block w-72 rounded-xl border-0 py-2 pl-10 pr-3 text-gray-900 ring-1 ring-inset ring-gray-200 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm bg-gray-50/50"
                placeholder="Cari pelamar...">

            <div id="searchDropdown"
                 class="absolute left-0 right-0 top-full mt-1 z-50 hidden bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
            </div>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50/50">
                <tr>
                    <th class="py-4 pl-6 pr-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-widest">No</th>
                    <th class="px-3 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-widest">Pelamar</th>
                    <th class="px-3 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-widest">Email</th>
                    <th class="px-3 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-widest">Job Role</th>
                    <th class="px-3 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-widest">Apply Date</th>
                    <th class="px-3 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-widest">Status</th>
                    <th class="px-3 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-widest">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 bg-white">
                @forelse($recruitments as $recruitment)
                <tr class="hover:bg-indigo-50/40 transition-colors duration-150 group recruitment-row"
                    data-name="{{ strtolower($recruitment->name) }}"
                    data-email="{{ strtolower($recruitment->email) }}"
                    data-role="{{ strtolower($recruitment->jobRole->role ?? '') }}">
                    <td class="whitespace-nowrap py-4 pl-6 pr-3 text-sm text-gray-400 font-medium">{{ $loop->iteration }}</td>
                    <td class="whitespace-nowrap px-3 py-4">
                        <div class="flex items-center gap-3">
                            <div class="flex h-9 w-9 items-center justify-center rounded-full bg-indigo-100 text-indigo-700 text-xs font-bold flex-shrink-0">
                                {{ strtoupper(substr($recruitment->name, 0, 1)) }}
                            </div>
                            <div>
                                <span class="text-sm font-semibold text-gray-900 group-hover:text-indigo-600 transition-colors">{{ $recruitment->name }}</span>
                                <div class="text-xs text-gray-400">{{ $recruitment->phone_number }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-600">{{ $recruitment->email }}</td>
                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-600">{{ $recruitment->jobRole->role ?? '-' }}</td>
                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-600">
                        {{ \Carbon\Carbon::parse($recruitment->apply_date)->format('d M Y') }}
                    </td>
                    <td class="whitespace-nowrap px-3 py-4 text-center">
                        @php
                            $pill = $recruitment->status=='Screening' ? 'bg-yellow-100 text-yellow-700' : ($recruitment->status=='Interview' ? 'bg-blue-100 text-blue-700' : ($recruitment->status=='Accepted' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'));
                            $dots = [
                                'Screening' => 'bg-yellow-500',
                                'Interview' => 'bg-blue-500',
                                'Accepted'  => 'bg-green-500',
                                'Rejected'  => 'bg-red-500',
                            ];
                        @endphp
                        <form action="{{ route('recruitment.status', $recruitment->id) }}" method="POST" class="status-dropdown inline-block">
                            @csrf
                            @method('PUT')
                            <button type="button" data-status-toggle class="inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-xs font-semibold cursor-pointer {{ $pill }}">
                                {{ $recruitment->status }}
                                <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            <div data-status-menu class="hidden fixed z-50 w-44 rounded-xl border border-gray-100 bg-white py-1 shadow-lg">
                                @foreach($dots as $val => $dot)
                                    <button type="submit" name="status" value="{{ $val }}"
                                        class="flex w-full items-center gap-3 px-4 py-2.5 text-left text-sm transition-colors hover:bg-indigo-50 border-b border-gray-50 last:border-0">
                                        <span class="h-2 w-2 rounded-full {{ $dot }}"></span>
                                        <span class="{{ $recruitment->status==$val ? 'font-semibold text-indigo-600' : 'text-gray-700' }}">{{ $val }}</span>
                                        @if($recruitment->status==$val)
                                            <svg class="ml-auto h-4 w-4 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        @endif
                                    </button>
                                @endforeach
                            </div>
                        </form>
                    </td>
                    <td class="whitespace-nowrap px-3 py-4 text-center text-sm font-medium">
                        <div class="flex justify-center gap-2">
                            <a href="{{ route('recruitment.show', $recruitment->id) }}" class="inline-flex items-center rounded-xl bg-indigo-50 px-3 py-1.5 text-xs font-semibold text-indigo-600 hover:bg-indigo-100 transition-colors">Detail</a>
                            <a href="{{ route('recruitment.edit', $recruitment->id) }}" class="inline-flex items-center rounded-xl bg-amber-50 px-3 py-1.5 text-xs font-semibold text-amber-600 hover:bg-amber-100 transition-colors">Edit</a>
                            <form action="{{ route('recruitment.destroy', $recruitment->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pelamar ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="inline-flex items-center rounded-xl bg-red-50 px-3 py-1.5 text-xs font-semibold text-red-600 hover:bg-red-100 transition-colors">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="py-16 text-center">
                        <h3 class="text-sm font-semibold text-gray-900">Belum ada data pelamar</h3>
                        <p class="mt-1 text-sm text-gray-500">Belum ada pelamar yang terdaftar.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="px-6 py-4 border-t border-gray-100 text-sm text-gray-500">
        Menampilkan {{ $recruitments->count() }} data pelamar.
    </div>

</div>

<script>

const searchInput = document.getElementById("searchInput");
const searchDropdown = document.getElementById("searchDropdown");

const rows = document.querySelectorAll(".recruitment-row");

let recruitments = [];

rows.forEach(function(row){

    recruitments.push({

        name: row.dataset.name,

        email: row.dataset.email,

        role: row.dataset.role,

        element: row

    });

});

function capitalize(text){

    return text.replace(/\b\w/g,function(char){

        return char.toUpperCase();

    });

}

searchInput.addEventListener("keyup",function(){

    const keyword=this.value.toLowerCase().trim();

    searchDropdown.innerHTML="";

    if(keyword===""){

        searchDropdown.classList.add("hidden");

        rows.forEach(function(row){

            row.style.display="";

        });

        return;

    }

    let result = recruitments.filter(function(item){

        return item.name.includes(keyword)

            || item.email.includes(keyword)

            || item.role.includes(keyword);

    });

    rows.forEach(function(row){

        row.style.display="none";

    });

    if(result.length===0){

        searchDropdown.classList.remove("hidden");

        searchDropdown.innerHTML=`

            <div class="px-4 py-3 text-sm text-gray-400">

                Pelamar tidak ditemukan

            </div>

        `;

        return;

    }

    result.forEach(function(item){

        item.element.style.display="";

        searchDropdown.innerHTML += `

            <div
                class="px-4 py-3 hover:bg-indigo-50 cursor-pointer border-b last:border-b-0">

                <div class="font-semibold text-gray-800">

                    ${capitalize(item.name)}

                </div>

                <div class="text-xs text-gray-400">

                    ${item.email}

                </div>

            </div>

        `;

    });

    searchDropdown.classList.remove("hidden");

});

document.addEventListener("click",function(e){

    if(!e.target.closest("#searchWrapper")){

        searchDropdown.classList.add("hidden");

    }

});

document.querySelectorAll('.status-dropdown').forEach(function(wrap){

    var toggle = wrap.querySelector('[data-status-toggle]');
    var menu   = wrap.querySelector('[data-status-menu]');

    toggle.addEventListener('click', function(e){

        e.stopPropagation();

        var opening = menu.classList.contains('hidden');

        document.querySelectorAll('[data-status-menu]').forEach(function(m){
            m.classList.add('hidden');
        });

        if (opening) {
            var r = toggle.getBoundingClientRect();
            menu.style.left = Math.max(8, Math.min(r.left, window.innerWidth - 176)) + 'px';
            menu.style.top  = (r.bottom + 6) + 'px';
            menu.classList.remove('hidden');
        }

    });

});

document.addEventListener('click', function(){
    document.querySelectorAll('[data-status-menu]').forEach(function(m){
        m.classList.add('hidden');
    });
});

</script>

@endsection
