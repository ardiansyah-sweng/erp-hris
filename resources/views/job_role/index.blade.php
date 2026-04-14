@php
    // Data Dummy Sementara untuk Job Role
    $dummyJobRoles = [
        ['id' => 1, 'name' => 'Software Engineer', 'department' => 'IT', 'level' => 'Staff'],
        ['id' => 2, 'name' => 'Data Analyst', 'department' => 'Data', 'level' => 'Senior'],
        ['id' => 3, 'name' => 'HR Manager', 'department' => 'Human Resources', 'level' => 'Manager'],
        ['id' => 4, 'name' => 'Quality Assurance', 'department' => 'IT', 'level' => 'Staff'],
        ['id' => 5, 'name' => 'Product Manager', 'department' => 'Product', 'level' => 'Manager'],
    ];
@endphp

<div>
    <h2>Daftar Job Role (Data Dummy)</h2>
    
    <table border="1" style="width: 100%; border-collapse: collapse; text-align: left; margin-top: 15px;">
        <thead>
            <tr style="background-color: #f2f2f2;">
                <th style="padding: 10px; border: 1px solid #ddd;">No</th>
                <th style="padding: 10px; border: 1px solid #ddd;">Nama Role</th>
                <th style="padding: 10px; border: 1px solid #ddd;">Departemen</th>
                <th style="padding: 10px; border: 1px solid #ddd;">Level</th>
                <th style="padding: 10px; border: 1px solid #ddd;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($dummyJobRoles as $role)
                <tr>
                    <td style="padding: 10px; border: 1px solid #ddd;">{{ $loop->iteration }}</td>
                    <td style="padding: 10px; border: 1px solid #ddd;">{{ $role['name'] }}</td>
                    <td style="padding: 10px; border: 1px solid #ddd;">{{ $role['department'] }}</td>
                    <td style="padding: 10px; border: 1px solid #ddd;">{{ $role['level'] }}</td>
                    <td style="padding: 10px; border: 1px solid #ddd;">
                        <button type="button">Detail</button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center; padding: 10px; border: 1px solid #ddd;">Data tidak tersedia</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
