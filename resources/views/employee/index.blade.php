@extends('layouts.app')

@section('title', 'Karyawan - ERP HRIS')

@section('content')

<div class="sm:flex sm:items-center sm:justify-between mb-8">
    <div>
        <h1 class="text-2xl font-bold text-gray-900 tracking-tight">
            Manajemen Karyawan
        </h1>
        <p class="mt-1 text-sm text-gray-500">
            Kelola dan pantau data karyawan perusahaan.
        </p>
    </div>
</div>

<!-- Statistik -->
<div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4 mb-8">

    <div class="bg-white overflow-hidden rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center mb-2">
            <div class="p-2.5 rounded-xl bg-indigo-50 text-indigo-600 mr-3">
                👥
            </div>
            <p class="text-sm font-medium text-gray-500">
                Total Karyawan
            </p>
        </div>

        <div class="flex items-baseline gap-2">
            <p class="text-3xl font-bold text-gray-900">
                {{ count($employees) }}
            </p>
            <span class="text-sm text-indigo-600 font-medium">
                karyawan
            </span>
        </div>
    </div>

    <div class="bg-white overflow-hidden rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center mb-2">
            <div class="p-2.5 rounded-xl bg-emerald-50 text-emerald-600 mr-3">
                ✅
            </div>
            <p class="text-sm font-medium text-gray-500">
                Aktif
            </p>
        </div>

        <div class="flex items-baseline gap-2">
            <p class="text-3xl font-bold text-gray-900">
                {{ count($employees) }}
            </p>
            <span class="text-sm text-emerald-600 font-medium">
                aktif
            </span>
        </div>
    </div>
</div>

<!-- Tabel -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow duration-300">

    <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center">
        <h3 class="text-base font-semibold text-gray-900">
            Daftar Karyawan
        </h3>

        <div class="relative w-80">
    <input id="employeeSearch" type="text"
    class="block w-full rounded-xl border-0 py-2 px-4 text-gray-900 ring-1 ring-inset ring-gray-200 placeholder:text-gray-400"
    placeholder="Cari karyawan...">
    <div id="searchResults" class="absolute left-0 top-full mt-2 w-full bg-white rounded-xl shadow-xl border border-gray-200 hidden z-50 max-h-72 overflow-y-auto"></div>
</div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">

            <thead class="bg-gray-50/50">
                <tr>
                    <th class="py-4 pl-6 pr-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-widest">
                        ID
                    </th>

                    <th class="px-3 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-widest">
                        Nama
                    </th>

                    <th class="px-3 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-widest">
                        Email
                    </th>

                    <th class="px-3 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-widest">
                        No HP
                    </th>

                    <th class="px-3 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-widest">
                        Tempat Lahir
                    </th>

                    <th class="px-3 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-widest">
                        Tanggal Lahir
                    </th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100 bg-white">

                @forelse($employees as $employee)

                <tr class="hover:bg-indigo-50/40 transition-colors duration-150 employee-row"
data-name="{{ $employee->name }}"
data-email="{{ $employee->email }}"
data-phone="{{ $employee->phone_number }}"
data-place="{{ $employee->place_of_birth }}"
data-birth="{{ \Carbon\Carbon::parse($employee->date_of_birth)->format('d-m-Y') }}">

                    <td class="py-4 pl-6 pr-3 text-sm font-medium text-gray-900">
                        {{ $employee->id }}
                    </td>

                    <td class="px-3 py-4 text-sm font-semibold text-gray-900">
                        {{ $employee->name }}
                    </td>

                    <td class="px-3 py-4 text-sm text-gray-600">
                        {{ $employee->email }}
                    </td>

                    <td class="px-3 py-4 text-sm text-gray-600">
                        {{ $employee->phone_number }}
                    </td>

                    <td class="px-3 py-4 text-sm text-gray-600">
                        {{ $employee->place_of_birth }}
                    </td>

                    <td class="px-3 py-4 text-sm text-gray-600">
                        {{ \Carbon\Carbon::parse($employee->date_of_birth)->format('d-m-Y') }}
                    </td>

                </tr>

                @empty

                <tr>
                    <td colspan="6" class="py-16 text-center">
                        <h3 class="text-sm font-semibold text-gray-900">
                            Belum ada data karyawan
                        </h3>
                    </td>
                </tr>

                @endforelse

            </tbody>

        </table>
    </div>

</div>


<script>
const search=document.getElementById('employeeSearch');
const box=document.getElementById('searchResults');
const rows=[...document.querySelectorAll('.employee-row')];
search.addEventListener('input',()=>{
 const q=search.value.toLowerCase().trim();
 if(!q){box.classList.add('hidden');box.innerHTML='';return;}
 let html='';
 rows.forEach(r=>{
   if(r.dataset.name.toLowerCase().includes(q)){
     html+=`<div class="p-3 border-b hover:bg-indigo-50 cursor-pointer"
     onclick="selectEmp('${r.dataset.name}','${r.dataset.email}','${r.dataset.phone}','${r.dataset.place}','${r.dataset.birth}')">
     <div class="font-semibold">${r.dataset.name}</div>
     <div class="text-sm text-gray-500">${r.dataset.email}</div>
     </div>`;
   }
 });
 box.innerHTML=html||'<div class="p-3 text-gray-500">Tidak ditemukan</div>';
 box.classList.remove('hidden');
});
function selectEmp(n,e,p,l,b){
 box.innerHTML=`<div class="p-4">
 <div class="text-lg font-bold mb-2">${n}</div>
 <div>Email : ${e}</div>
 <div>No HP : ${p}</div>
 <div>Tempat Lahir : ${l}</div>
 <div>Tanggal Lahir : ${b}</div>
 </div>`;
}
document.addEventListener('click',e=>{
 if(!search.parentElement.contains(e.target)) box.classList.add('hidden');
});
</script>



<!-- Modal Tambah Karyawan -->
<div id="employeeModal" class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50">
    <div class="bg-white w-full max-w-2xl rounded-2xl p-6">
        <div class="flex justify-between items-center mb-5">
            <h2 class="text-xl font-bold">Tambah Karyawan</h2>
            <button type="button" onclick="closeModal()" class="text-2xl">&times;</button>
        </div>

        <form action="/employees" method="POST">
            @csrf

            <div class="grid grid-cols-2 gap-4">
                <input name="name" class="border rounded-lg p-3" placeholder="Nama">
                <input name="email" class="border rounded-lg p-3" placeholder="Email">
                <input name="phone_number" class="border rounded-lg p-3" placeholder="No HP">
                <input name="place_of_birth" class="border rounded-lg p-3" placeholder="Tempat Lahir">
                <input type="date" name="date_of_birth" class="border rounded-lg p-3">
                <input name="age" class="border rounded-lg p-3" placeholder="Umur">
                <input name="id_number" class="border rounded-lg p-3" placeholder="NIK">
                <input name="address" class="border rounded-lg p-3" placeholder="Alamat">

                <select name="role_id" class="border rounded-lg p-3 col-span-2">
                    <option value="1">HR Manager</option>
                    <option value="2">Software Engineer</option>
                    <option value="3">Data Analyst</option>
                    <option value="4">Quality Assurance</option>
                    <option value="5">Product Manager</option>
                </select>
            </div>

            <div class="flex justify-end gap-3 mt-6">
                <button type="button" onclick="closeModal()" class="border px-4 py-2 rounded-lg">Batal</button>
                <button type="submit" class="bg-indigo-600 text-white px-5 py-2 rounded-lg">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
function openModal(){
    document.getElementById('employeeModal').classList.remove('hidden');
    document.getElementById('employeeModal').classList.add('flex');
}
function closeModal(){
    document.getElementById('employeeModal').classList.add('hidden');
    document.getElementById('employeeModal').classList.remove('flex');
}
</script>

@endsection