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

        <!-- Akun -->
        <div class="bg-white border border-gray-100 rounded-3xl shadow-sm p-6">

            <h2 class="text-lg font-semibold text-gray-900 mb-1">
                Informasi Akun
            </h2>

            <p class="text-sm text-gray-500 mb-6">
                Kelola data akun pengguna.
            </p>

            <div class="space-y-4">

                <div>
                    <label class="block text-sm text-gray-500 mb-2">
                        Nama
                    </label>

                    <input type="text"
                           value="Admin HR"
                           class="w-full rounded-xl border border-gray-200 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                <div>
                    <label class="block text-sm text-gray-500 mb-2">
                        Email
                    </label>

                    <input type="email"
                           value="admin@erphris.com"
                           class="w-full rounded-xl border border-gray-200 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

            </div>

        </div>

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

    </div>

</div>

@endsection