@extends('layouts.app')

@section('title', 'Pengaturan')

@section('content')

<div class="max-w-5xl mx-auto">

    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">
            Pengaturan
        </h1>

        <p class="mt-1 text-gray-500">
            Kelola preferensi dan keamanan akun Anda.
        </p>
    </div>

    <div class="space-y-6">

        <!-- Password -->
        <div class="bg-white border border-gray-100 rounded-3xl shadow-sm p-6">

            <h2 class="text-lg font-semibold text-gray-900 mb-1">
                Keamanan
            </h2>

            <p class="text-sm text-gray-500 mb-6">
                Ubah password akun Anda.
            </p>

            <button class="px-5 py-3 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 transition-colors">
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

                    <select class="rounded-xl border border-gray-200 px-4 py-2">
                        <option>Indonesia</option>
                        <option>English</option>
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

                    <select class="rounded-xl border border-gray-200 px-4 py-2">
                        <option>Light</option>
                        <option>Dark (Coming Soon)</option>
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

                        <input type="checkbox" checked class="sr-only peer">

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

                        <input type="checkbox" checked class="sr-only peer">

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

                        <input type="checkbox" class="sr-only peer">

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

</div>

@endsection