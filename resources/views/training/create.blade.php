@extends('layouts.app')

@section('title','Tambah Training')

@section('content')

<div class="max-w-4xl mx-auto">

    <div class="bg-white rounded-2xl shadow p-8">

        <h1 class="text-2xl font-bold mb-6">
            Tambah Training
        </h1>

        <form action="{{ route('training.store') }}" method="POST">

            @csrf

            <div class="grid grid-cols-2 gap-6">

                <!-- Judul -->
                <div>
                    <label class="block mb-2 font-medium">
                        Judul Training
                    </label>

                    <input
                        type="text"
                        name="title"
                        value="{{ old('title') }}"
                        class="w-full border rounded-xl px-4 py-3 @error('title') border-red-500 @enderror">

                    @error('title')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Trainer -->
                <div>
                    <label class="block mb-2 font-medium">
                        Trainer
                    </label>

                    <input
                        type="text"
                        name="trainer"
                        value="{{ old('trainer') }}"
                        class="w-full border rounded-xl px-4 py-3 @error('trainer') border-red-500 @enderror">

                    @error('trainer')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Departemen -->
                <div>
                    <label class="block mb-2 font-medium">
                        Departemen
                    </label>

                    <select
                        name="department_id"
                        class="w-full border rounded-xl px-4 py-3 @error('department_id') border-red-500 @enderror">

                        <option value="">-- Pilih Departemen --</option>

                        @foreach($departments as $department)
                            <option
                                value="{{ $department->id }}"
                                {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                {{ $department->name }}
                            </option>
                        @endforeach

                    </select>

                    @error('department_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tanggal -->
                <div>
                    <label class="block mb-2 font-medium">
                        Tanggal
                    </label>

                    <input
                        type="date"
                        name="training_date"
                        value="{{ old('training_date') }}"
                        class="w-full border rounded-xl px-4 py-3 @error('training_date') border-red-500 @enderror">

                    @error('training_date')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Lokasi -->
                <div>
                    <label class="block mb-2 font-medium">
                        Lokasi
                    </label>

                    <input
                        type="text"
                        name="location"
                        value="{{ old('location') }}"
                        class="w-full border rounded-xl px-4 py-3 @error('location') border-red-500 @enderror">

                    @error('location')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div>
                    <label class="block mb-2 font-medium">
                        Status
                    </label>

                    <select
                        name="status"
                        class="w-full border rounded-xl px-4 py-3 @error('status') border-red-500 @enderror">

                        <option value="Scheduled"
                            {{ old('status') == 'Scheduled' ? 'selected' : '' }}>
                            Scheduled
                        </option>

                        <option value="Ongoing"
                            {{ old('status') == 'Ongoing' ? 'selected' : '' }}>
                            Ongoing
                        </option>

                        <option value="Completed"
                            {{ old('status') == 'Completed' ? 'selected' : '' }}>
                            Completed
                        </option>

                        <option value="Cancelled"
                            {{ old('status') == 'Cancelled' ? 'selected' : '' }}>
                            Cancelled
                        </option>

                    </select>

                    @error('status')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            <!-- Deskripsi -->
            <div class="mt-6">

                <label class="block mb-2 font-medium">
                    Deskripsi
                </label>

                <textarea
                    name="description"
                    rows="4"
                    class="w-full border rounded-xl px-4 py-3 @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>

                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror

            </div>

            <div class="flex justify-end gap-3 mt-8">

                <a href="{{ route('training.index') }}"
                    class="px-5 py-3 rounded-xl border hover:bg-gray-100">
                    Kembali
                </a>

                <button
                    type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-xl">
                    Simpan
                </button>

            </div>

        </form>

    </div>

</div>

@endsection