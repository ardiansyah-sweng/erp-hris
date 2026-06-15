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
            Informasi akun pengguna ERP HRIS.
        </p>
    </div>

    <!-- Card -->
    <div class="bg-white border border-gray-100 rounded-3xl shadow-sm overflow-hidden">

        <!-- Banner -->
        <div class="h-32 bg-gradient-to-r from-indigo-500 to-violet-500"></div>

        <!-- Content -->
        <div class="px-8 pb-8">

            <!-- Avatar -->
            <div class="-mt-14 mb-6">

                <img class="w-28 h-28 rounded-full border-4 border-white shadow-md"
                     src="https://ui-avatars.com/api/?name=Admin+HR&background=4f46e5&color=fff&bold=true"
                     alt="User">

            </div>

            <!-- Name -->
            <h2 class="text-2xl font-bold text-gray-900">
                Admin HR
            </h2>

            <p class="text-gray-500 mb-8">
                admin@erphris.com
            </p>

            <!-- Information -->
            <div class="grid md:grid-cols-2 gap-6">

                <div>
                    <p class="text-sm text-gray-500 mb-2">
                        Nama Lengkap
                    </p>

                    <div class="bg-gray-50 rounded-xl px-4 py-3">
                        Admin HR
                    </div>
                </div>

                <div>
                    <p class="text-sm text-gray-500 mb-2">
                        Email
                    </p>

                    <div class="bg-gray-50 rounded-xl px-4 py-3">
                        admin@erphris.com
                    </div>
                </div>

                <div>
                    <p class="text-sm text-gray-500 mb-2">
                        Role
                    </p>

                    <div class="bg-gray-50 rounded-xl px-4 py-3">
                        Administrator
                    </div>
                </div>

                <div>
                    <p class="text-sm text-gray-500 mb-2">
                        Status
                    </p>

                    <div class="bg-green-50 text-green-600 rounded-xl px-4 py-3">
                        Active
                    </div>
                </div>

            </div>

        </div>

    </div>

</div>

@endsection