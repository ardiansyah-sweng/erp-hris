@extends('layouts.app')

@section('title', 'Karyawan - ERP HRIS')

@section('content')

@php
    $allEmployees = collect($employees);
    $aktif = $allEmployees; // sesuaikan jika ada kolom status
@endphp

<div class="sm:flex sm:items-center sm:justify-between mb-8">
    <div>
        <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Manajemen Karyawan</h1>
        <p class="mt-1 text-sm text-gray-500">Kelola dan pantau data karyawan perusahaan.</p>
    </div>

    <form action="{{ route('employees.import') }}" method="POST" enctype="multipart/form-data" class="mt-4 sm:mt-0 flex items-center gap-3">
        @csrf

        <input 
            type="file" 
            name="csv_file" 
            accept=".csv"
            required
            class="block text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"
        >

        <button 
            type="submit"
            class="inline-flex items-center rounded-xl bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700">
            Import CSV
        </button>
    </form>
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
<div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4 mb-8">

    <div onclick="openEmployeeModal('total')"
         class="cursor-pointer bg-white overflow-hidden rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col transition-transform hover:-translate-y-1 duration-300">
        <div class="flex items-center mb-2">
            <div class="p-2.5 rounded-xl bg-indigo-50 text-indigo-600 mr-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <p class="text-sm font-medium text-gray-500">Total Karyawan</p>
        </div>
        <div class="flex items-baseline gap-2">
            <p class="text-3xl font-bold text-gray-900">{{ count($employees) }}</p>
            <span class="text-sm text-indigo-600 font-medium">karyawan</span>
        </div>
    </div>

    <div onclick="openEmployeeModal('aktif')"
         class="cursor-pointer bg-white overflow-hidden rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col transition-transform hover:-translate-y-1 duration-300">
        <div class="flex items-center mb-2">
            <div class="p-2.5 rounded-xl bg-emerald-50 text-emerald-600 mr-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <p class="text-sm font-medium text-gray-500">Karyawan Aktif</p>
        </div>
        <div class="flex items-baseline gap-2">
            <p class="text-3xl font-bold text-gray-900">{{ count($employees) }}</p>
            <span class="text-sm text-emerald-600 font-medium">aktif</span>
        </div>
    </div>

</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow duration-300">

    <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center">
        <h3 class="text-base font-semibold text-gray-900">Daftar Karyawan</h3>

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
                placeholder="Cari karyawan...">

            <div id="searchDropdown"
                 class="absolute left-0 right-0 top-full mt-1 z-50 hidden bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
            </div>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50/50">
                <tr>
                    <th class="py-4 pl-6 pr-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-widest">ID</th>
                    <th class="px-3 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-widest">Nama</th>
                    <th class="px-3 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-widest">Email</th>
                    <th class="px-3 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-widest">No HP</th>
                    <th class="px-3 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-widest">Tempat Lahir</th>
                    <th class="px-3 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-widest">Tanggal Lahir</th>
                    <th class="px-3 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-widest">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 bg-white" id="tableBody">
                @forelse($employees as $employee)
                <tr class="hover:bg-indigo-50/40 transition-colors duration-150 group employee-row"
                    data-name="{{ strtolower($employee->name) }}">
                    <td class="whitespace-nowrap py-4 pl-6 pr-3 text-sm text-gray-400 font-medium">#{{ $employee->id }}</td>
                    <td class="whitespace-nowrap px-3 py-4">
                        <div class="flex items-center gap-3">
                            <div class="flex h-9 w-9 items-center justify-center rounded-full bg-indigo-100 text-indigo-700 text-xs font-bold flex-shrink-0">
                                {{ strtoupper(substr($employee->name, 0, 1)) }}
                            </div>
                            <span class="text-sm font-semibold text-gray-900 group-hover:text-indigo-600 transition-colors cursor-pointer" onclick="openProfileModal({{ json_encode($employee) }})">
                                {{ $employee->name }}
                            </span>
                        </div>
                    </td>
                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-600">{{ $employee->email }}</td>
                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-600">{{ $employee->phone_number }}</td>
                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-600">{{ $employee->place_of_birth }}</td>
                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-600">
                        {{ \Carbon\Carbon::parse($employee->date_of_birth)->format('d-m-Y') }}
                    </td>
                    <td class="whitespace-nowrap px-3 py-4 text-center text-sm font-medium">
                        <a href="{{ route('employees.show', $employee->id) }}" class="inline-flex items-center rounded-xl bg-indigo-50 px-3 py-1.5 text-xs font-semibold text-indigo-600 hover:bg-indigo-100 transition-colors">
                            Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="py-16 text-center">
                        <h3 class="text-sm font-semibold text-gray-900">Belum ada data karyawan</h3>
                        <p class="mt-1 text-sm text-gray-500">Belum ada karyawan yang terdaftar.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="px-6 py-4 border-t border-gray-100 text-sm text-gray-500">
        Menampilkan {{ count($employees) }} data karyawan.
    </div>

</div>

<div id="employeeModal" class="fixed inset-0 z-50 hidden bg-black/40">
    <div class="absolute inset-y-0 right-0 w-full lg:w-[70%] bg-white shadow-2xl overflow-y-auto">
        <div class="sticky top-0 bg-white z-10 px-8 py-6 border-b flex justify-between items-center">
            <div>
                <h3 id="modalTitle" class="text-2xl font-bold text-gray-900">Daftar Karyawan</h3>
                <p id="modalSubtitle" class="text-sm text-gray-500 mt-1">Informasi data karyawan</p>
            </div>
            <button onclick="closeEmployeeModal()"
                    class="px-4 py-2 rounded-xl bg-red-50 text-red-600 hover:bg-red-100 font-semibold transition-colors">
                Tutup
            </button>
        </div>
        <div id="modalContent" class="p-8 grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5"></div>
    </div>
</div>

<div id="profileModal" class="fixed inset-0 z-50 hidden bg-black/40 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden relative">

        <div class="bg-indigo-600 px-6 py-8 text-center relative">
            <button onclick="closeProfileModal()"
                    class="absolute top-4 right-4 text-indigo-200 hover:text-white transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
            <div id="profileAvatar"
                 class="w-20 h-20 rounded-full bg-white text-indigo-600 text-2xl font-bold flex items-center justify-center mx-auto mb-3">
            </div>
            <h2 id="profileName" class="text-xl font-bold text-white"></h2>
            <p id="profileEmail" class="text-indigo-200 text-sm mt-1"></p>
        </div>

        <div class="p-6 grid grid-cols-2 gap-4">
            <div class="bg-gray-50 rounded-xl p-4">
                <p class="text-xs text-gray-400 mb-1">No HP</p>
                <p id="profilePhone" class="text-sm font-semibold text-gray-800"></p>
            </div>
            <div class="bg-gray-50 rounded-xl p-4">
                <p class="text-xs text-gray-400 mb-1">Tempat Lahir</p>
                <p id="profilePob" class="text-sm font-semibold text-gray-800"></p>
            </div>
            <div class="bg-gray-50 rounded-xl p-4 col-span-2">
                <p class="text-xs text-gray-400 mb-1">Tanggal Lahir</p>
                <p id="profileDob" class="text-sm font-semibold text-gray-800"></p>
            </div>
            
            <div class="col-span-2 mt-2">
                <a id="profileEditBtn" href="#" 
                   class="w-full inline-flex justify-center items-center gap-2 rounded-xl bg-amber-500 hover:bg-amber-600 px-4 py-3 text-sm font-bold text-white shadow-sm transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit Data Karyawan Ini
                </a>
            </div>
        </div>

        <!-- Footer Modal -->
        <div class="px-6 py-4 bg-gray-50 border-t flex justify-end">
            <a id="profileDetailLink" href="#" class="inline-flex items-center rounded-xl bg-indigo-600 px-4 py-2 text-xs font-semibold text-white shadow-sm hover:bg-indigo-700 transition-colors">
                Detail Selengkapnya
            </a>
        </div>

    </div>
</div>

<script>
const employeeData = {
    total: @json($allEmployees->values()),
    aktif: @json($aktif->values()),
};

const modalTitles = {
    total: 'Total Seluruh Karyawan',
    aktif: 'Karyawan Aktif',
};

// Base URL edit halaman
const editBaseUrl = "{{ url('/employee/test-edit') }}";

// ── Modal List (stat card) ──────────────────────────────────────────────────
function openEmployeeModal(type) {
    const modal    = document.getElementById('employeeModal');
    const title    = document.getElementById('modalTitle');
    const subtitle = document.getElementById('modalSubtitle');
    const content  = document.getElementById('modalContent');

    title.innerText    = modalTitles[type];
    subtitle.innerText = employeeData[type].length + ' karyawan ditemukan';
    content.innerHTML  = '';

    employeeData[type].forEach(function(item) {
        var initials = item.name.split(' ').map(function(w){ return w[0]; }).join('').substring(0, 2).toUpperCase();
        var dob = item.date_of_birth
            ? new Date(item.date_of_birth).toLocaleDateString('id-ID', {day:'2-digit', month:'long', year:'numeric'})
            : '-';
        var itemJson = JSON.stringify(item).replace(/"/g, '&quot;');

        // Ditambahkan tombol edit kecil di dalam card modal agar fleksibel
        content.innerHTML += '<div class="bg-white border border-gray-100 rounded-2xl p-5 shadow-sm hover:shadow-md transition flex flex-col justify-between">'
            + '<div>'
            + '<div class="flex items-center justify-between gap-2 mb-4" onclick="closeEmployeeModal(); openProfileModal(' + itemJson + ')">'
            + '<div class="flex items-center gap-3">'
            + '<div class="w-12 h-12 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold text-sm flex-shrink-0">' + initials + '</div>'
            + '<div><p class="font-bold text-gray-900 hover:text-indigo-600 transition">' + item.name + '</p><p class="text-sm text-gray-500">' + (item.email || '') + '</p></div>'
            + '</div>'
            + '</div>'
            + '<div class="grid grid-cols-2 gap-3 text-xs mb-4">'
            + '<div class="bg-gray-50 rounded-xl p-3"><p class="text-gray-400">No HP</p><p class="font-semibold text-gray-700 mt-1">' + (item.phone_number || '-') + '</p></div>'
            + '<div class="bg-gray-50 rounded-xl p-3"><p class="text-gray-400">Tempat Lahir</p><p class="font-semibold text-gray-700 mt-1">' + (item.place_of_birth || '-') + '</p></div>'
            + '<div class="bg-gray-50 rounded-xl p-3 col-span-2"><p class="text-gray-400">Tanggal Lahir</p><p class="font-semibold text-gray-700 mt-1">' + dob + '</p></div>'
            + '</div>'
            + '</div>'
            + '<a href="' + editBaseUrl + '?id=' + item.id + '" class="w-full text-center inline-flex justify-center items-center gap-1.5 text-xs font-bold text-amber-700 bg-amber-50 hover:bg-amber-100 py-2.5 rounded-xl transition">'
            + '⚙️ Edit Karyawan'
            + '</a>'
            + '</div>';
    });

    modal.classList.remove('hidden');
}

function closeEmployeeModal() {
    document.getElementById('employeeModal').classList.add('hidden');
}

// ── Modal Profil ────────────────────────────────────────────────────────────
function openProfileModal(item) {
    var initials = item.name.split(' ').map(function(w){ return w[0]; }).join('').substring(0, 2).toUpperCase();
    var dob = item.date_of_birth
        ? new Date(item.date_of_birth).toLocaleDateString('id-ID', {day:'2-digit', month:'long', year:'numeric'})
        : '-';

    document.getElementById('profileAvatar').innerText = initials;
    document.getElementById('profileName').innerText   = item.name;
    document.getElementById('profileEmail').innerText  = item.email || '-';
    document.getElementById('profilePhone').innerText  = item.phone_number || '-';
    document.getElementById('profilePob').innerText    = item.place_of_birth || '-';
    document.getElementById('profileDob').innerText    = dob;
    document.getElementById('profileDetailLink').href  = '/employees/' + item.id;

    document.getElementById('profileModal').classList.remove('hidden');
}

function closeProfileModal() {
    document.getElementById('profileModal').classList.add('hidden');
}

// ── Search Autocomplete ─────────────────────────────────────────────────────
var searchInput    = document.getElementById('searchInput');
var searchDropdown = document.getElementById('searchDropdown');
var allData        = @json($allEmployees->values());

function highlightMatch(text, query) {
    var regex = new RegExp('(' + query.replace(/[.*+?^${}()|[\]\\]/g, '\\$&') + ')', 'gi');
    return text.replace(regex, '<strong class="text-indigo-600 font-bold">$1</strong>');
}

searchInput.addEventListener('input', function() {
    var query = this.value.trim().toLowerCase();

    // filter baris tabel
    document.querySelectorAll('.employee-row').forEach(function(row) {
        row.style.display = row.dataset.name.includes(query) ? '' : 'none';
    });

    if (query.length === 0) {
        searchDropdown.classList.add('hidden');
        return;
    }

    var matched = allData.filter(function(e) {
        return e.name.toLowerCase().includes(query);
    });

    if (matched.length === 0) {
        searchDropdown.innerHTML = '<div class="px-4 py-3 text-sm text-gray-400 text-center">Karyawan tidak ditemukan</div>';
        searchDropdown.classList.remove('hidden');
        return;
    }

    searchDropdown.innerHTML = matched.map(function(item) {
        var initials    = item.name.split(' ').map(function(w){ return w[0]; }).join('').substring(0, 2).toUpperCase();
        var highlighted = highlightMatch(item.name, query);
        var itemJson    = JSON.stringify(item).replace(/"/g, '&quot;');
        return '<div class="flex items-center gap-3 px-4 py-3 hover:bg-indigo-50 cursor-pointer border-b border-gray-50 last:border-0 transition-colors" onclick="selectEmployee(' + itemJson + ')">'
            + '<div class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-600 text-xs font-bold flex items-center justify-center flex-shrink-0">' + initials + '</div>'
            + '<div><p class="text-sm text-gray-800">' + highlighted + '</p><p class="text-xs text-gray-400">' + (item.email || '') + '</p></div>'
            + '</div>';
    }).join('');

    searchDropdown.classList.remove('hidden');
});

function selectEmployee(item) {
    searchInput.value = item.name;
    searchDropdown.classList.add('hidden');
    openProfileModal(item);
}

// tutup dropdown klik di luar
document.addEventListener('click', function(e) {
    if (!document.getElementById('searchWrapper').contains(e.target)) {
        searchDropdown.classList.add('hidden');
    }
});

// tutup profil modal klik backdrop
document.getElementById('profileModal').addEventListener('click', function(e) {
    if (e.target === this) closeProfileModal();
});
</script>

@endsection