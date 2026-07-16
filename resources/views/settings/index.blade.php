@extends('layouts.app')

@section('title', 'Pengaturan')

@section('content')

<div 
    class="max-w-5xl mx-auto
    {{ Auth::user()->theme == 'Dark' ? 'dark' : '' }}"
>

    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">
            Pengaturan
        </h1>

        <p class="mt-1 text-gray-500">
            Kelola preferensi dan keamanan akun Anda.
        </p>
    </div>

    <form action="{{ route('settings.update') }}" method="POST">

        @csrf
        @method('PUT')

        <div class="space-y-6">

            <!-- Password -->
            <div class="bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-3xl shadow-sm p-6">

                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-1">
                    Keamanan
                </h2>

                <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">
                    Ubah password akun Anda.
                </p>

                <button
                    type="button"
                    id="openPasswordModal"
                    class="px-5 py-3 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 transition-colors">

                    Ubah Password

                </button>

            </div>

            <div class="bg-white border border-gray-100 rounded-3xl shadow-sm p-6">

                <h2 class="text-lg font-semibold text-gray-900 mb-1">
                    Preferensi
                </h2>

                <p class="text-sm text-gray-500 mb-6">
                    Pengaturan tampilan aplikasi.
                </p>

                <div class="space-y-5">

                    <div class="flex justify-between items-center">

                        <div>
                            <p class="font-medium text-gray-900">
                                Bahasa
                            </p>

                            <p class="text-sm text-gray-500">
                                Bahasa yang digunakan aplikasi.
                            </p>
                        </div>

                        <select 
                            name="language" 
                            class="rounded-xl border border-gray-200 px-4 py-2">

                            <option 
                                value="Indonesia"
                                @if(Auth::user()->language == 'Indonesia')
                                    selected
                                @endif>
                                Indonesia
                            </option>

                            <option 
                                value="English"
                                @if(Auth::user()->language == 'English')
                                    selected
                                @endif>
                                English
                            </option>

                        </select>

                    </div>

                    <div class="flex justify-between items-center">

                        <div>
                            <p class="font-medium text-gray-900">
                                Tema
                            </p>

                            <p class="text-sm text-gray-500">
                                Pilih tampilan aplikasi.
                            </p>
                        </div>

                        <select 
                            name="theme" 
                            class="rounded-xl border border-gray-200 px-4 py-2">

                            <option 
                                value="Light"
                                @if(Auth::user()->theme == 'Light')
                                    selected
                                @endif>
                                Light
                            </option>

                            <option 
                                value="Dark"
                                @if(Auth::user()->theme == 'Dark')
                                    selected
                                @endif>
                                Dark
                            </option>

                        </select>

                    </div>

                </div>

            </div>

            <!-- Notifikasi -->
            <div class="bg-white border border-gray-100 rounded-3xl shadow-sm p-6">

                <h2 class="text-lg font-semibold text-gray-900 mb-1">
                    Notifikasi
                </h2>

                <p class="text-sm text-gray-500 mb-6">
                    Atur notifikasi yang ingin Anda terima.
                </p>

                <div class="space-y-6">

                    <!-- Email -->
                    <div class="flex justify-between items-center">

                        <div>

                            <p class="font-medium text-gray-900">
                                Email Notifikasi
                            </p>

                            <p class="text-sm text-gray-500">
                                Terima pemberitahuan melalui email.
                            </p>

                        </div>

                        <label class="relative inline-flex items-center cursor-pointer">

                            <input 
                            type="checkbox"
                            name="email_notification"
                            value="1"
                            class="sr-only peer"

                            @if(Auth::user()->email_notification)
                            checked
                            @endif
                            >

                            <div class="w-11 h-6 bg-gray-200 rounded-full
                                        peer peer-checked:bg-indigo-600
                                        after:content-[''] after:absolute after:top-0.5 after:left-[2px]
                                        after:bg-white after:border after:rounded-full
                                        after:h-5 after:w-5 after:transition-all
                                        peer-checked:after:translate-x-full">
                            </div>

                        </label>

                    </div>

                    <!-- Cuti -->
                    <div class="flex justify-between items-center">

                        <div>

                            <p class="font-medium text-gray-900">
                                Notifikasi Cuti
                            </p>

                            <p class="text-sm text-gray-500">
                                Dapatkan pemberitahuan saat ada pengajuan cuti.
                            </p>

                        </div>

                        <label class="relative inline-flex items-center cursor-pointer">

                            <input 
                            type="checkbox"
                            name="leave_notification"
                            value="1"
                            class="sr-only peer"

                            @if(Auth::user()->leave_notification)
                            checked
                            @endif
                            >

                            <div class="w-11 h-6 bg-gray-200 rounded-full
                                        peer peer-checked:bg-indigo-600
                                        after:content-[''] after:absolute after:top-0.5 after:left-[2px]
                                        after:bg-white after:border after:rounded-full
                                        after:h-5 after:w-5 after:transition-all
                                        peer-checked:after:translate-x-full">
                            </div>

                        </label>

                    </div>

                    <!-- Payroll -->
                    <div class="flex justify-between items-center">

                        <div>

                            <p class="font-medium text-gray-900">
                                Notifikasi Payroll
                            </p>

                            <p class="text-sm text-gray-500">
                                Beri tahu saat data penggajian diperbarui.
                            </p>

                        </div>

                        <label class="relative inline-flex items-center cursor-pointer">

                            <input 
                            type="checkbox"
                            name="payroll_notification"
                            value="1"
                            class="sr-only peer"

                            @if(Auth::user()->payroll_notification)
                            checked
                            @endif
                            >

                            <div class="w-11 h-6 bg-gray-200 rounded-full
                                        peer peer-checked:bg-indigo-600
                                        after:content-[''] after:absolute after:top-0.5 after:left-[2px]
                                        after:bg-white after:border after:rounded-full
                                        after:h-5 after:w-5 after:transition-all
                                        peer-checked:after:translate-x-full">
                            </div>

                        </label>

                    </div>

                </div>

            </div>
        </div>
        <div class="flex justify-end mt-6">

            <button
                type="submit"
                class="px-6 py-3 rounded-xl bg-indigo-600 text-white hover:bg-indigo-700">

                Simpan Perubahan

            </button>

        </div>
    </form>
</div>

<div id="passwordModal"
    class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50">


    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6">

        <h2 class="text-lg font-semibold mb-5">
            Ubah Password
        </h2>

        <form action="{{route('settings.password')}}" method="POST">

            @csrf
            @method('PUT')


            <div class="space-y-4">


                <input
                type="password"
                name="current_password"
                placeholder="Password Lama"
                class="w-full rounded-xl border px-4 py-3">


                <input
                type="password"
                name="password"
                placeholder="Password Baru"
                class="w-full rounded-xl border px-4 py-3">


                <input
                type="password"
                name="password_confirmation"
                placeholder="Konfirmasi Password"
                class="w-full rounded-xl border px-4 py-3">


                </div>
                    <div class="flex justify-end gap-3 mt-6">

                        <button
                        type="button"
                        id="closePasswordModal"
                        class="px-5 py-2 border rounded-xl">
                        Batal
                        </button>

                        <button
                        type="submit"
                        class="px-5 py-2 bg-indigo-600 text-white rounded-xl">
                        Simpan
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>

    const modal = document.getElementById('passwordModal');

    document
    .getElementById('openPasswordModal')
    .onclick=function(){

        modal.classList.remove('hidden');
        modal.classList.add('flex');

    }


    document
    .getElementById('closePasswordModal')
    .onclick=function(){

        modal.classList.add('hidden');
        modal.classList.remove('flex');

    }
</script>

@endsection