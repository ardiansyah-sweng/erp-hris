@extends('layouts.app')

@section('title', 'Tambah Karyawan')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-lg shadow p-6">
        <h1 class="text-2xl font-semibold mb-4">Tambah Karyawan</h1>

        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-50 border border-red-100 text-red-700 rounded">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="/employees" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Pilih dari Pelamar (Accepted)</label>
                    <select id="recruitmentSelect" class="mt-1 block w-full rounded-md border-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-200">
                        <option value="">-- Pilih Pelamar --</option>
                        @foreach(($acceptedRecruitments ?? []) as $recruit)
                            <option value="{{ $recruit->id }}">{{ $recruit->name }} — {{ $recruit->email }} ({{ $recruit->jobrole->role ?? 'Tanpa Role' }})</option>
                        @endforeach
                    </select>
                    @if(empty($acceptedRecruitments))
                        <p class="mt-1 text-xs text-gray-400">Belum ada pelamar berstatus Accepted.</p>
                    @endif
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Nama</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="mt-1 block w-full rounded-md border-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-200" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="mt-1 block w-full rounded-md border-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-200">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
                    <input type="text" name="phone_number" value="{{ old('phone_number') }}" class="mt-1 block w-full rounded-md border-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-200">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Nomor Identitas</label>
                    <input type="text" name="id_number" value="{{ old('id_number') }}" class="mt-1 block w-full rounded-md border-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-200">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Tempat Lahir</label>
                    <input type="text" name="place_of_birth" value="{{ old('place_of_birth') }}" class="mt-1 block w-full rounded-md border-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-200">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                    <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}" class="mt-1 block w-full rounded-md border-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-200">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Usia</label>
                    <input type="number" name="age" id="age" value="{{ old('age') }}" min="0" readonly class="mt-1 block w-full rounded-md border-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-200 bg-gray-50 cursor-not-allowed">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Job Role</label>
                    <select name="role_id" id="roleSelect" class="mt-1 block w-full rounded-md border-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-200">
                        <option value="">-- Pilih Role --</option>
                        @foreach(($jobroles ?? []) as $role)
                            <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>{{ $role->role }}</option>
                        @endforeach
                    </select>
                    <input type="hidden" id="roleIdHidden" value="{{ old('role_id') }}">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Alamat</label>
                    <textarea name="address" rows="3" class="mt-1 block w-full rounded-md border-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-200">{{ old('address') }}</textarea>
                </div>
            </div>

            <div class="mt-6 flex items-center gap-3">
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Simpan</button>
                <a href="/employees" class="px-4 py-2 border border-gray-200 rounded-md text-gray-700">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const dateInput = document.querySelector('input[name="date_of_birth"]');
        const ageInput = document.getElementById('age');

        function calculateAge() {
            if (!dateInput.value) {
                ageInput.value = '';
                return;
            }
            const dob = new Date(dateInput.value);
            const today = new Date();
            let age = today.getFullYear() - dob.getFullYear();
            const monthDiff = today.getMonth() - dob.getMonth();
            if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dob.getDate())) {
                age--;
            }
            ageInput.value = age >= 0 ? age : '';
        }

        dateInput.addEventListener('change', calculateAge);
        dateInput.addEventListener('input', calculateAge);

        if (dateInput.value) {
            calculateAge();
        }

        const recruitmentSelect = document.getElementById('recruitmentSelect');
        const roleSelect = document.getElementById('roleSelect');
        const roleIdHidden = document.getElementById('roleIdHidden');
        const recruitData = @json($acceptedRecruitments ?? []);
        const textFields = {
            name: document.querySelector('input[name="name"]'),
            email: document.querySelector('input[name="email"]'),
            phone_number: document.querySelector('input[name="phone_number"]'),
        };

        function lockField(input, lock) {
            if (lock) {
                input.setAttribute('readonly', '');
                input.classList.add('bg-gray-50', 'cursor-not-allowed');
            } else {
                input.removeAttribute('readonly');
                input.classList.remove('bg-gray-50', 'cursor-not-allowed');
            }
        }

        function applyRecruit(id) {
            const rec = recruitData.find(function (r) { return String(r.id) === String(id); });
            const lock = !!rec;

            Object.keys(textFields).forEach(function (key) {
                if (rec) {
                    textFields[key].value = rec[key] || '';
                }
                lockField(textFields[key], lock);
            });

            if (rec) {
                roleSelect.value = rec.role_id;
                roleSelect.setAttribute('disabled', '');
                roleSelect.removeAttribute('name');
                roleIdHidden.setAttribute('name', 'role_id');
                roleIdHidden.value = rec.role_id;
            } else {
                roleSelect.removeAttribute('disabled');
                roleSelect.setAttribute('name', 'role_id');
                roleIdHidden.removeAttribute('name');
                roleIdHidden.value = '';
            }
        }

        recruitmentSelect.addEventListener('change', function (e) {
            applyRecruit(e.target.value);
        });
    });
</script>
@endpush
