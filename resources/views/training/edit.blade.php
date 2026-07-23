@extends('layouts.app')

@section('title','Edit Training')

@section('content')

<div class="max-w-5xl mx-auto bg-white rounded-2xl shadow p-8">

    <h1 class="text-3xl font-bold mb-8">
        Edit Training
    </h1>

    <form action="{{ route('training.update',$training->id) }}"
          method="POST">

        @csrf
        @method('PUT')

        <div class="grid grid-cols-2 gap-6">

            <div>
                <label class="font-medium">Judul Training</label>

                <input
                    type="text"
                    name="title"
                    value="{{ old('title',$training->title) }}"
                    class="w-full border rounded-xl px-4 py-3 mt-2">
            </div>

            <div>
                <label class="font-medium">Trainer</label>

                <input
                    type="text"
                    name="trainer"
                    value="{{ old('trainer',$training->trainer) }}"
                    class="w-full border rounded-xl px-4 py-3 mt-2">
            </div>

            <div>

                <label class="font-medium">
                    Departemen
                </label>

                <select
                    name="department_id"
                    class="w-full border rounded-xl px-4 py-3 mt-2">

                    @foreach($departments as $department)

                        <option
                            value="{{ $department->id }}"
                            {{ old('department_id',$training->department_id)==$department->id?'selected':'' }}>

                            {{ $department->name }}

                        </option>

                    @endforeach

                </select>

            </div>

            <div>

                <label class="font-medium">
                    Tanggal
                </label>

                <input
                    type="date"
                    name="training_date"
                    value="{{ old('training_date',$training->training_date) }}"
                    class="w-full border rounded-xl px-4 py-3 mt-2">

            </div>

            <div>

                <label class="font-medium">
                    Lokasi
                </label>

                <input
                    type="text"
                    name="location"
                    value="{{ old('location',$training->location) }}"
                    class="w-full border rounded-xl px-4 py-3 mt-2">

            </div>

            <div>

                <label class="font-medium">
                    Status
                </label>

                <select
                    name="status"
                    class="w-full border rounded-xl px-4 py-3 mt-2">

                    <option value="Scheduled" {{ $training->status=='Scheduled'?'selected':'' }}>
                        Scheduled
                    </option>

                    <option value="Ongoing" {{ $training->status=='Ongoing'?'selected':'' }}>
                        Ongoing
                    </option>

                    <option value="Completed" {{ $training->status=='Completed'?'selected':'' }}>
                        Completed
                    </option>

                    <option value="Cancelled" {{ $training->status=='Cancelled'?'selected':'' }}>
                        Cancelled
                    </option>

                </select>

            </div>

        </div>

        <div class="mt-6">

            <label class="font-medium">
                Deskripsi
            </label>

            <textarea
                name="description"
                rows="5"
                class="w-full border rounded-xl px-4 py-3 mt-2">{{ old('description',$training->description) }}</textarea>

        </div>

        <div class="flex justify-end gap-3 mt-8">

            <a href="{{ route('training.index') }}"
                class="px-6 py-3 rounded-xl border">

                Kembali

            </a>

            <button
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-xl">

                Update

            </button>

        </div>

    </form>

</div>

@endsection