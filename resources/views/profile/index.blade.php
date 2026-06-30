@extends('layouts.app')

@section('title', 'Profil')

@section('content')

<div class="max-w-3xl mx-auto">

    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">
            Profil
        </h1>

        <p class="mt-1 text-gray-500">
            Kelola informasi profil akun Anda.
        </p>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">

        <!-- Avatar -->
        <div class="flex flex-col items-center">

            <div class="relative">

                <img
                    class="w-28 h-28 rounded-full ring-4 ring-indigo-100"
                    src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=4f46e5&color=fff&bold=true"
                    alt="Avatar">

                <button
                    class="absolute bottom-0 right-0 w-10 h-10 rounded-full bg-white border border-gray-200 shadow flex items-center justify-center hover:bg-gray-50">

                    <svg class="w-5 h-5 text-gray-600"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24">

                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.5"
                            d="M6.827 6.175A2.31 2.31 0 018.52 5.5h6.958a2.31 2.31 0 011.692.675l1.155 1.248A2.31 2.31 0 0120 9v7.5A2.5 2.5 0 0117.5 19h-11A2.5 2.5 0 014 16.5V9a2.31 2.31 0 01.633-1.577l1.194-1.248z"/>

                        <circle cx="12"
                                cy="13"
                                r="3"/>

                    </svg>

                </button>

            </div>

        </div>

        <form class="mt-10 space-y-6">

            <div>

                <label class="block text-sm font-medium text-gray-600 mb-2">
                    Nama Lengkap
                </label>

                <input
                    type="text"
                    value="{{ Auth::user()->name }}"
                    class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3
                        focus:outline-none
                        focus:ring-2 focus:ring-indigo-500
                        focus:border-indigo-500">

            </div>

            <div>

                <label class="block text-sm font-medium text-gray-600 mb-2">
                    Email
                </label>

                <input
                    type="email"
                    value="{{ Auth::user()->email }}"
                    class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3
                        focus:outline-none
                        focus:ring-2 focus:ring-indigo-500
                        focus:border-indigo-500">

            </div>

            <div>

                <label class="block text-sm font-medium text-gray-600 mb-2">
                    Role
                </label>

                <input
                    type="text"
                    value="Administrator"
                    readonly
                    class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3
                        focus:outline-none
                        focus:ring-2 focus:ring-indigo-500
                        focus:border-indigo-500">

            </div>

            <div class="flex justify-end gap-3 pt-4">

                <button
                    type="reset"
                    class="px-5 py-3 rounded-xl border border-gray-200 hover:bg-gray-100">

                    Batal

                </button>

                <button
                    type="submit"
                    class="px-6 py-3 rounded-xl bg-indigo-600 text-white hover:bg-indigo-700">

                    Simpan Perubahan

                </button>

            </div>

        </form>

    </div>

</div>

@endsection