@extends('layouts.app')

@section('title', 'Edit Karyawan - ERP HRIS')

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Edit Data Karyawan</h1>
            <p class="mt-1 text-sm text-gray-500">Perbarui informasi karyawan di bawah ini.</p>
        </div>
        <div class="mt-4 sm:mt-0 flex gap-3">
            <a href="{{ route('employees.show', $employee->id) }}"
               class="inline-flex items-center gap-2 rounded-xl border border-gray-200 bg-white px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50 transition-colors shadow-sm">
                ← Kembali ke Detail
            </a>
        </div>
    </div>

    {{-- Success / Error Messages --}}
    @if(session('success'))
        <div class="rounded-xl bg-green-50 border border-green-200 px-4 py-3 text-sm text-green-700 font-medium">
            ✓ {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="rounded-xl bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-700">
            <p class="font-semibold mb-1">Terdapat kesalahan pada input:</p>
            <ul class="list-disc list-inside space-y-0.5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form Edit --}}
    <form action="{{ route('employees.update', $employee->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

            {{-- Avatar & Nama --}}
            <div class="px-6 py-5 border-b border-gray-100 flex items-center gap-4 bg-gradient-to-r from-indigo-50 to-white">
                <div class="flex h-14 w-14 items-center justify-center rounded-full bg-indigo-600 text-white text-xl font-bold shadow-md">
                    {{ strtoupper(substr($employee->name, 0, 1)) }}
                </div>
                <div>
                    <p class="text-xs text-gray-500 font-medium uppercase tracking-widest">ID Karyawan</p>
                    <p class="text-lg font-bold text-gray-800">#{{ $employee->id }} &mdash; {{ $employee->name }}</p>
                </div>
            </div>

            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Nama Lengkap --}}
                <div class="col-span-1 md:col-span-2">
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" id="name" name="name"
                           value="{{ old('name', $employee->name) }}"
                           class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm text-gray-900 shadow-sm focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 outline-none transition @error('name') border-red-400 bg-red-50 @enderror"
                           placeholder="Masukkan nama lengkap" required>
                    @error('name') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-1.5">Email <span class="text-red-500">*</span></label>
                    <input type="email" id="email" name="email"
                           value="{{ old('email', $employee->email) }}"
                           class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm text-gray-900 shadow-sm focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 outline-none transition @error('email') border-red-400 bg-red-50 @enderror"
                           placeholder="contoh@email.com" required>
                    @error('email') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                {{-- No HP --}}
                <div>
                    <label for="phone_number" class="block text-sm font-semibold text-gray-700 mb-1.5">No. Telepon <span class="text-red-500">*</span></label>
                    <input type="text" id="phone_number" name="phone_number"
                           value="{{ old('phone_number', $employee->phone_number) }}"
                           class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm text-gray-900 shadow-sm focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 outline-none transition @error('phone_number') border-red-400 bg-red-50 @enderror"
                           placeholder="08xx-xxxx-xxxx" required>
                    @error('phone_number') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                {{-- NIK --}}
                <div>
                    <label for="id_number" class="block text-sm font-semibold text-gray-700 mb-1.5">NIK <span class="text-red-500">*</span></label>
                    <input type="text" id="id_number" name="id_number"
                           value="{{ old('id_number', $employee->id_number) }}"
                           class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm text-gray-900 shadow-sm focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 outline-none transition @error('id_number') border-red-400 bg-red-50 @enderror"
                           placeholder="16 digit NIK" required>
                    @error('id_number') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                {{-- Jabatan --}}
                <div>
                    <label for="role_id" class="block text-sm font-semibold text-gray-700 mb-1.5">Jabatan <span class="text-red-500">*</span></label>
                    <select id="role_id" name="role_id"
                            class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm text-gray-900 shadow-sm focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 outline-none transition bg-white @error('role_id') border-red-400 bg-red-50 @enderror"
                            required>
                        <option value="">-- Pilih Jabatan --</option>
                        @foreach($jobroles as $jobrole)
                            <option value="{{ $jobrole->id }}" {{ old('role_id', $employee->role_id) == $jobrole->id ? 'selected' : '' }}>
                                {{ $jobrole->role }}
                            </option>
                        @endforeach
                    </select>
                    @error('role_id') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                {{-- Status --}}
                <div>
                    <label for="status" class="block text-sm font-semibold text-gray-700 mb-1.5">Status <span class="text-red-500">*</span></label>
                    <select id="status" name="status"
                            class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm text-gray-900 shadow-sm focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 outline-none transition bg-white @error('status') border-red-400 bg-red-50 @enderror"
                            required>
                        <option value="active"   {{ old('status', $employee->status) === 'active'   ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ old('status', $employee->status) === 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                    @error('status') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                {{-- Tempat Lahir --}}
                <div>
                    <label for="place_of_birth" class="block text-sm font-semibold text-gray-700 mb-1.5">Tempat Lahir <span class="text-red-500">*</span></label>
                    <input type="text" id="place_of_birth" name="place_of_birth"
                           value="{{ old('place_of_birth', $employee->place_of_birth) }}"
                           class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm text-gray-900 shadow-sm focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 outline-none transition @error('place_of_birth') border-red-400 bg-red-50 @enderror"
                           placeholder="Nama kota" required>
                    @error('place_of_birth') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                {{-- Tanggal Lahir --}}
                <div>
                    <label for="date_of_birth" class="block text-sm font-semibold text-gray-700 mb-1.5">Tanggal Lahir <span class="text-red-500">*</span></label>
                    <input type="date" id="date_of_birth" name="date_of_birth"
                           value="{{ old('date_of_birth', \Carbon\Carbon::parse($employee->date_of_birth)->format('Y-m-d')) }}"
                           class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm text-gray-900 shadow-sm focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 outline-none transition @error('date_of_birth') border-red-400 bg-red-50 @enderror"
                           required>
                    @error('date_of_birth') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                {{-- Alamat --}}
                <div class="col-span-1 md:col-span-2">
                    <label for="address" class="block text-sm font-semibold text-gray-700 mb-1.5">Alamat <span class="text-red-500">*</span></label>
                    <textarea id="address" name="address" rows="3"
                              class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm text-gray-900 shadow-sm focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 outline-none transition resize-none @error('address') border-red-400 bg-red-50 @enderror"
                              placeholder="Masukkan alamat lengkap" required>{{ old('address', $employee->address) }}</textarea>
                    @error('address') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

            </div>

            {{-- Footer Tombol --}}
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex items-center justify-between">
                <a href="{{ route('employees.show', $employee->id) }}"
                   class="inline-flex items-center gap-1.5 rounded-xl border border-gray-200 bg-white px-5 py-2.5 text-sm font-semibold text-gray-600 hover:bg-gray-100 transition-colors">
                    Batal
                </a>
                <button type="submit"
                        class="inline-flex items-center gap-1.5 rounded-xl bg-indigo-600 px-6 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-400 focus:ring-offset-2 transition-all">
                    💾 Simpan Perubahan
                </button>
            </div>

        </div>
    </form>

</div>
@endsection
