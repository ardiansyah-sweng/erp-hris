<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roleId = DB::table('job_roles')->insertGetId([
            'role' => 'cashier',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Insert dummy employees kasir
        DB::table('employees')->insert([
            [
                'name' => 'Budi Santoso',
                'email' => 'budi@example.com',
                'phone_number' => '081234567890',
                'place_of_birth' => 'Jakarta',
                'date_of_birth' => '1995-01-15',
                'address' => 'Jl. Mawar No.1',
                'id_number' => '3201234567890001',
                'age' => 29,
                'role_id' => $roleId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Siti Rahayu',
                'email' => 'siti@example.com',
                'phone_number' => '089876543210',
                'place_of_birth' => 'Bandung',
                'date_of_birth' => '1997-05-20',
                'address' => 'Jl. Melati No.5',
                'id_number' => '3201234567890002',
                'age' => 27,
                'role_id' => $roleId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
