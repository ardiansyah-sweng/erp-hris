@extends('layouts.app')

@section('content')

<div class="max-w-3xl mx-auto">

    <div class="bg-white rounded-xl shadow border p-6">

        <h1 class="text-2xl font-bold text-gray-900 mb-6">
            Tambah Pengumuman
        </h1>

        <form action="{{ route('announcement.store') }}" method="POST">

            @csrf

            <div class="mb-5">
                <label class="block mb-2 font-medium">
                    Judul
                </label>

                <input
                    type="text"
                    name="title"
                    class="w-full border rounded-lg px-4 py-2"
                    required>
            </div>

            <div class="mb-5">

                <label class="block mb-2 font-medium">
                    Isi Pengumuman
                </label>

                <textarea
                    name="content"
                    rows="5"
                    class="w-full border rounded-lg px-4 py-2"
                    required></textarea>

            </div>

            <div class="mb-5">

                <label class="block mb-2 font-medium">
                    Tanggal Publish
                </label>

                <input
                    type="date"
                    name="publish_date"
                    class="w-full border rounded-lg px-4 py-2"
                    required>

            </div>

            <div class="mb-6">

                <label class="block mb-2 font-medium">
                    Status
                </label>

                <select
                    name="status"
                    class="w-full border rounded-lg px-4 py-2">

                    <option value="Aktif">
                        Aktif
                    </option>

                    <option value="Draft">
                        Draft
                    </option>

                </select>

            </div>

            <div class="mt-8 flex items-center justify-end gap-3">

                <a
                    href="{{ route('announcement.index') }}"
                    class="inline-flex items-center rounded-lg bg-gray-500 px-5 py-2.5 text-white hover:bg-gray-600">

                    Batal

                </a>

                <button
                    type="submit"
                    class="inline-flex items-center rounded-lg bg-blue-600 px-5 py-2.5 text-white hover:bg-blue-700">

                    Simpan

                </button>

            </div>

        </form>

    </div>

</div>

@endsection