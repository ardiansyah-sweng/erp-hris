<!DOCTYPE html>
<html>
<head>
    <title>Detail Employee</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<div class="max-w-4xl mx-auto mt-8">
    <h3 class="text-2xl font-bold mb-6 text-gray-800">Detail Employee</h3>

    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="p-6">

            <table class="w-full table-auto border-collapse border border-gray-300">
                <tbody>
                    <tr class="border-b border-gray-300">
                        <th class="w-48 px-4 py-2 text-left font-semibold bg-gray-50">ID</th>
                        <td class="px-4 py-2">{{ $employee->id }}</td>
                    </tr>

                    <tr class="border-b border-gray-300">
                        <th class="px-4 py-2 text-left font-semibold bg-gray-50">Nama</th>
                        <td class="px-4 py-2">{{ $employee->name }}</td>
                    </tr>

                    <tr class="border-b border-gray-300">
                        <th class="px-4 py-2 text-left font-semibold bg-gray-50">Email</th>
                        <td class="px-4 py-2">{{ $employee->email }}</td>
                    </tr>

                    <tr class="border-b border-gray-300">
                        <th class="px-4 py-2 text-left font-semibold bg-gray-50">Nomor Telepon</th>
                        <td class="px-4 py-2">{{ $employee->phone_number }}</td>
                    </tr>

                    <tr class="border-b border-gray-300">
                        <th class="px-4 py-2 text-left font-semibold bg-gray-50">Tempat Lahir</th>
                        <td class="px-4 py-2">{{ $employee->place_of_birth }}</td>
                    </tr>

                    <tr class="border-b border-gray-300">
                        <th class="px-4 py-2 text-left font-semibold bg-gray-50">Tanggal Lahir</th>
                        <td class="px-4 py-2">{{ $employee->date_of_birth }}</td>
                    </tr>

                    <tr class="border-b border-gray-300">
                        <th class="px-4 py-2 text-left font-semibold bg-gray-50">Alamat</th>
                        <td class="px-4 py-2">{{ $employee->address }}</td>
                    </tr>

                    <tr class="border-b border-gray-300">
                        <th class="px-4 py-2 text-left font-semibold bg-gray-50">NIK</th>
                        <td class="px-4 py-2">{{ $employee->id_number }}</td>
                    </tr>

                    <tr class="border-b border-gray-300">
                        <th class="px-4 py-2 text-left font-semibold bg-gray-50">Usia</th>
                        <td class="px-4 py-2">{{ $employee->age }}</td>
                    </tr>

                    <tr class="border-b border-gray-300">
                        <th class="px-4 py-2 text-left font-semibold bg-gray-50">Job Role</th>
                        <td class="px-4 py-2">{{ optional($employee->jobrole)->role ?? 'Belum tersedia' }}</td>
                    </tr>

                    <tr class="border-b border-gray-300">
                        <th class="px-4 py-2 text-left font-semibold bg-gray-50">Dibuat Pada</th>
                        <td class="px-4 py-2">{{ $employee->created_at }}</td>
                    </tr>

                    <tr>
                        <th class="px-4 py-2 text-left font-semibold bg-gray-50">Diupdate Pada</th>
                        <td class="px-4 py-2">{{ $employee->updated_at }}</td>
                    </tr>
                </tbody>
            </table>

            <a href="{{ url('/employees') }}" class="inline-block mt-4 px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 transition">
                Kembali ke Daftar Employee
            </a>

        </div>
    </div>
</div>

</body>
</html>