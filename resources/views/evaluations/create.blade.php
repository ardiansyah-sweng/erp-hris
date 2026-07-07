<x-app-layout title="Tambah Evaluasi Kinerja">
    <div class="space-y-8 max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="sm:flex sm:items-center sm:justify-between mb-0">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Tambah Evaluasi Kinerja</h1>
                <p class="mt-1 text-sm text-gray-500">Isi formulir berikut untuk mencatat penilaian karyawan.</p>
            </div>

            <div class="mt-4 sm:mt-0">
                <a href="{{ route('evaluations.index') }}"
                   class="inline-flex items-center rounded-xl border border-gray-300 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50 transition-all">
                    <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Kembali
                </a>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-100">
                <h3 class="text-base font-semibold text-gray-900">Form Tambah Evaluasi Kinerja</h3>
            </div>

            <form action="{{ route('evaluations.store') }}" method="POST" class="p-6 space-y-6">
                @csrf

                <div>
                    <label for="employee_id" class="block text-sm font-medium text-gray-700 mb-2">Karyawan</label>
                    <select id="employee_id" name="employee_id" class="block w-full rounded-xl border-0 py-3 px-4 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm bg-white">
                        <option value="">-- Pilih Karyawan --</option>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->id }}" @selected(old('employee_id') == $employee->id)>{{ $employee->name }}</option>
                        @endforeach
                    </select>
                    @error('employee_id')
                        <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="evaluation_date" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Evaluasi</label>
                    <input type="date" id="evaluation_date" name="evaluation_date" value="{{ old('evaluation_date') }}" class="block w-full rounded-xl border-0 py-3 px-4 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm bg-white">
                    @error('evaluation_date')
                        <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="score" class="block text-sm font-medium text-gray-700 mb-2">Skor</label>
                    <select id="score" name="score" class="block w-full rounded-xl border-0 py-3 px-4 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm bg-white">
                        <option value="">Pilih Skor</option>
                        @for ($i = 1; $i <= 5; $i++)
                            <option value="{{ $i }}" @selected(old('score') == $i)>{{ $i }}</option>
                        @endfor
                    </select>
                    @error('score')
                        <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="feedback" class="block text-sm font-medium text-gray-700 mb-2">Feedback</label>
                    <textarea id="feedback" name="feedback" rows="4" class="block w-full rounded-xl border-0 py-3 px-4 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm bg-white">{{ old('feedback') }}</textarea>
                    @error('feedback')
                        <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                    <a href="{{ route('evaluations.index') }}" class="rounded-xl border border-gray-300 px-5 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50 transition-all">Batal</a>
                    <button type="submit" class="inline-flex items-center rounded-xl bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 transition-all">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
