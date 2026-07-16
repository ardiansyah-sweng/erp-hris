@extends('layouts.app')

@section('title', 'Profil')

@section('content')

<div class="max-w-5xl mx-auto">

    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">
            Profil
        </h1>

        <p class="mt-1 text-gray-500">
            Kelola informasi profil akun Anda.
        </p>
    </div>

    <div id="alert-box">

        @if(session('success'))

            <div class="mb-6 rounded-xl bg-green-100 text-green-700 px-4 py-3">
                {{ session('success') }}
            </div>

        @elseif($errors->has('profile_photo'))

            <div class="mb-6 rounded-xl bg-red-100 text-red-700 px-4 py-3">
                {{ $errors->first('profile_photo') }}
            </div>

        @endif

    </div>

    <form
        action="{{ route('profile.update') }}"
        method="POST"
        enctype="multipart/form-data"
        class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 space-y-6">

        @csrf
        @method('PUT')

        <!-- Avatar -->
        <div class="flex flex-col items-center">

            <div class="relative">

                @if(Auth::user()->profile_photo)

                    <img
                        id="preview-image"
                        src="{{ asset('storage/' . Auth::user()->profile_photo) }}"
                        class="w-28 h-28 rounded-full ring-4 ring-indigo-100 object-cover">

                @else

                    <img
                        id="preview-image"
                        src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=4f46e5&color=fff&bold=true"
                        class="w-28 h-28 rounded-full ring-4 ring-indigo-100 object-cover">

                @endif

                <input
                    type="file"
                    id="profile_photo"
                    name="profile_photo"
                    accept="image/*"
                    class="hidden">

                <button
                    type="button"
                    onclick="document.getElementById('profile_photo').click()"
                    class="absolute bottom-0 right-0 w-10 h-10 rounded-full bg-white border border-gray-200 shadow hover:bg-gray-50 flex items-center justify-center">

                    <svg class="w-5 h-5 text-gray-600"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24">

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.5"
                            d="M6.827 6.175A2.31 2.31 0 018.52 5.5h6.958a2.31 2.31 0 011.692.675l1.155 1.248A2.31 2.31 0 0120 9v7.5A2.5 2.5 0 0117.5 19h-11A2.5 2.5 0 014 16.5V9a2.31 2.31 0 01.633-1.577l1.194-1.248z"/>

                        <circle
                            cx="12"
                            cy="13"
                            r="3"/>

                    </svg>

                </button>

            </div>

        </div>

        <!-- Nama -->

        <div>

            <label class="block text-sm font-medium text-gray-600 mb-2">
                Nama Lengkap
            </label>

            <input 
                id="name" 
                type="text" 
                name="name" 
                value="{{ old('name', Auth::user()->name) }}" 
                class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">

            @error('name')
                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
            @enderror

        </div>

        <!-- Email -->

        <div>

            <label class="block text-sm font-medium text-gray-600 mb-2">
                Email
            </label>

            <input 
                id="email" 
                type="email" 
                name="email" 
                value="{{ old('email', Auth::user()->email) }}" 
                class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">

            @error('email')
                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
            @enderror

        </div>

        <!-- Role -->

        <div>

            <label class="block text-sm font-medium text-gray-600 mb-2">
                Role
            </label>

            <input 
                type="text" 
                value="Administrator"
                readonly 
                class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">

        </div>

        <!-- Button -->

        <div class="flex justify-between items-center pt-4">

            @if(Auth::user()->profile_photo)

                <button
                    type="button"
                    id="deletePhotoBtn"
                    class="px-5 py-3 rounded-xl bg-red-500 text-white hover:bg-red-700">

                    Hapus Foto

                </button>

            @else

                <div></div>

            @endif

            <div class="flex gap-3">

                <button
                    type="button"
                    id="cancelBtn"
                    class="px-5 py-3 rounded-xl border border-gray-300 hover:bg-gray-100">

                    Batal

                </button>

                <button
                    type="submit"
                    class="px-6 py-3 rounded-xl bg-indigo-600 text-white hover:bg-indigo-700">

                    Simpan Perubahan

                </button>

            </div>

        </div>

    </form>

    @if(Auth::user()->profile_photo)

    <form
        id="deletePhotoForm"
        action="{{ route('profile.photo.delete') }}"
        method="POST"
        style="display:none;">

        @csrf
        @method('DELETE')

    </form>

    @endif

</div>

<div
    id="deleteModal"
    class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50">

    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6">

        <div class="flex items-center gap-3">

            <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center">

                <svg class="w-6 h-6 text-red-600"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24">

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 9v4m0 4h.01M10.29 3.86l-7.5 13A1 1 0 003.65 18h16.7a1 1 0 00.86-1.5l-7.5-13a1 1 0 00-1.72 0z"/>

                </svg>

            </div>

            <div>

                <h2 class="text-lg font-semibold text-gray-900">
                    Hapus Foto Profil?
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    Foto profil yang dihapus tidak dapat dikembalikan.
                </p>

            </div>

        </div>

        <div class="mt-8 flex justify-end gap-3">

            <button
                id="cancelDeleteBtn"
                class="px-5 py-2 rounded-xl border border-gray-300 hover:bg-gray-100">

                Batal

            </button>

            <button
                id="confirmDeleteBtn"
                class="px-5 py-2 rounded-xl bg-red-600 text-white hover:bg-red-700">

                Ya, Hapus

            </button>

        </div>

    </div>

</div>

<script>

const imageInput = document.getElementById('profile_photo');
const preview = document.getElementById('preview-image');

const nameInput = document.getElementById('name');
const emailInput = document.getElementById('email');
const cancelBtn = document.getElementById('cancelBtn');

const originalImage = preview.src;
const originalName = nameInput.value;
const originalEmail = emailInput.value;

let selectedImage = false;

const photoError = document.getElementById('photo-error');
const alertBox = document.getElementById('alert-box');

imageInput.addEventListener('change', function () {

    const file = this.files[0];

    if (!file) return;

    if (file.size > 2 * 1024 * 1024) {

        alertBox.innerHTML = `
            <div class="mb-6 rounded-xl bg-red-100 text-red-700 px-4 py-3">
                Gagal mengunggah foto. Ukuran foto maksimal 2 MB.
            </div>
        `;
        this.value = "";

        return;
    }

    photoError.classList.add("hidden");

    preview.src = URL.createObjectURL(file);

    selectedImage = true;

});

// Tombol batal

cancelBtn.addEventListener('click', function(){

    preview.src = originalImage;

    nameInput.value = originalName;

    emailInput.value = originalEmail;

    imageInput.value = "";

    selectedImage = false;

});

const deleteModal = document.getElementById('deleteModal');

const deleteBtn = document.getElementById('deletePhotoBtn');

const cancelDeleteBtn = document.getElementById('cancelDeleteBtn');

const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');

if(deleteBtn){

    deleteBtn.addEventListener('click', function(){

        deleteModal.classList.remove('hidden');

        deleteModal.classList.add('flex');

    });

}

cancelDeleteBtn.addEventListener('click', function(){

    deleteModal.classList.remove('flex');

    deleteModal.classList.add('hidden');

});

confirmDeleteBtn.addEventListener('click', function(){

    document.getElementById('deletePhotoForm').submit();

});

deleteModal.addEventListener('click', function(e){

    if(e.target === deleteModal){

        deleteModal.classList.remove('flex');

        deleteModal.classList.add('hidden');

    }

});

</script>

@endsection