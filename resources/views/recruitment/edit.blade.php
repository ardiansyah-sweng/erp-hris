@extends('layouts.app')

@section('title', 'Edit Pelamar - ERP HRIS')

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Edit Data Pelamar</h1>
            <p class="mt-1 text-sm text-gray-500">Perbarui informasi pelamar di bawah ini.</p>
        </div>
        <div class="mt-4 sm:mt-0 flex gap-3">
            <a href="{{ route('recruitment.show', $recruitment->id) }}"
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
    <form action="{{ route('recruitment.update', $recruitment->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

            {{-- Avatar & Nama --}}
            <div class="px-6 py-5 border-b border-gray-100 flex items-center gap-4 bg-gradient-to-r from-indigo-50 to-white">
                <div class="flex h-14 w-14 items-center justify-center rounded-full bg-indigo-600 text-white text-xl font-bold shadow-md">
                    {{ strtoupper(substr($recruitment->name, 0, 1)) }}
                </div>
                <div>
                    <p class="text-xs text-gray-500 font-medium uppercase tracking-widest">ID Pelamar</p>
                    <p class="text-lg font-bold text-gray-800">#{{ $recruitment->id }} — {{ $recruitment->name }}</p>
                </div>
            </div>

            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Nama --}}
                <div class="col-span-1 md:col-span-2">
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Pelamar <span class="text-red-500">*</span></label>
                    <input type="text" id="name" name="name"
                           value="{{ old('name', $recruitment->name) }}"
                           class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm text-gray-900 shadow-sm focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 outline-none transition @error('name') border-red-400 bg-red-50 @enderror"
                           placeholder="Masukkan nama pelamar" required>
                    @error('name') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-1.5">Email <span class="text-red-500">*</span></label>
                    <input type="email" id="email" name="email"
                           value="{{ old('email', $recruitment->email) }}"
                           class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm text-gray-900 shadow-sm focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 outline-none transition @error('email') border-red-400 bg-red-50 @enderror"
                           placeholder="contoh@email.com" required>
                    @error('email') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                {{-- No HP --}}
                <div>
                    <label for="phone_number" class="block text-sm font-semibold text-gray-700 mb-1.5">No. Telepon <span class="text-red-500">*</span></label>
                    <input type="text" id="phone_number" name="phone_number"
                           value="{{ old('phone_number', $recruitment->phone_number) }}"
                           class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm text-gray-900 shadow-sm focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 outline-none transition @error('phone_number') border-red-400 bg-red-50 @enderror"
                           placeholder="08xx-xxxx-xxxx" required>
                    @error('phone_number') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                {{-- Job Role --}}
                <div>
                    <label for="role_id" class="block text-sm font-semibold text-gray-700 mb-1.5">Job Role <span class="text-red-500">*</span></label>
                    <select id="role_id" name="role_id"
                            class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm text-gray-900 shadow-sm focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 outline-none transition bg-white @error('role_id') border-red-400 bg-red-50 @enderror"
                            required>
                        <option value="">-- Pilih Job Role --</option>
                        @foreach($jobroles as $jobrole)
                            <option value="{{ $jobrole->id }}" {{ old('role_id', $recruitment->role_id) == $jobrole->id ? 'selected' : '' }}>
                                {{ $jobrole->role }}
                            </option>
                        @endforeach
                    </select>
                    @error('role_id') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                {{-- Tanggal Apply --}}
                <div>
                    <label for="apply_date" class="block text-sm font-semibold text-gray-700 mb-1.5">Tanggal Apply <span class="text-red-500">*</span></label>
                    <input type="date" id="apply_date" name="apply_date"
                           value="{{ old('apply_date', $recruitment->apply_date) }}"
                           class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm text-gray-900 shadow-sm focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 outline-none transition @error('apply_date') border-red-400 bg-red-50 @enderror"
                           required>
                    @error('apply_date') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                {{-- Status --}}
                <div>
                    <label for="status" class="block text-sm font-semibold text-gray-700 mb-1.5">Status <span class="text-red-500">*</span></label>
                    <select id="status" name="status"
                            class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm text-gray-900 shadow-sm focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 outline-none transition bg-white @error('status') border-red-400 bg-red-50 @enderror"
                            required>
                        <option value="Screening" {{ old('status', $recruitment->status) == 'Screening' ? 'selected' : '' }}>Screening</option>
                        <option value="Interview" {{ old('status', $recruitment->status) == 'Interview' ? 'selected' : '' }}>Interview</option>
                        <option value="Accepted"  {{ old('status', $recruitment->status) == 'Accepted'  ? 'selected' : '' }}>Accepted</option>
                        <option value="Rejected"  {{ old('status', $recruitment->status) == 'Rejected'  ? 'selected' : '' }}>Rejected</option>
                    </select>
                    @error('status') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                {{-- CV Sekarang --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">CV Sekarang</label>
                    @if($recruitment->cv)
                        <a href="{{ asset('storage/'.$recruitment->cv) }}" target="_blank"
                           class="inline-flex items-center gap-1.5 rounded-xl bg-red-50 px-3 py-2 text-xs font-semibold text-red-600 hover:bg-red-100 transition-colors">
                            📄 Lihat CV
                        </a>
                    @else
                        <p class="text-sm text-gray-400 pt-1.5">Tidak ada CV</p>
                    @endif
                </div>

                {{-- Ganti CV --}}
                <div>
                    <label for="cv" class="block text-sm font-semibold text-gray-700 mb-1.5">Ganti CV (PDF)</label>
                    <input type="file" id="cv" name="cv" accept=".pdf"
                           class="w-full rounded-xl border border-gray-200 px-4 py-2 text-sm text-gray-600 shadow-sm focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 outline-none transition">
                </div>

                {{-- Catatan --}}
                <div class="col-span-1 md:col-span-2">
                    <label for="notes" class="block text-sm font-semibold text-gray-700 mb-1.5">Catatan</label>
                    <textarea id="notes" name="notes" rows="4"
                              class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm text-gray-900 shadow-sm focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 outline-none transition resize-none @error('notes') border-red-400 bg-red-50 @enderror"
                              placeholder="Masukkan catatan pelamar">{{ old('notes', $recruitment->notes) }}</textarea>
                    @error('notes') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

            </div>

            {{-- Footer Tombol --}}
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex items-center justify-between">
                <a href="{{ route('recruitment.show', $recruitment->id) }}"
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
