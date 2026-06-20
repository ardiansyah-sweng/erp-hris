<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Employee;

class CreateStatusEmployeeTest extends TestCase
{
    /**
     * Test apakah halaman UI sementara filter employee bisa diakses.
     */
    public function test_halaman_filter_status_bisa_diakses(): void
    {
        $response = $this->get('/employees-status-temp');

        $response->assertStatus(200);
    }

    /**
     * Test menambahkan data employee active & inactive langsung ke database lokal.
     */
    public function test_bisa_menambahkan_employee_status_ke_database(): void
    {
        // 1. Tambah data Active
        $employeeActive = Employee::create([
            'name'           => 'Rian Wijaya Test',
            'email'          => 'rian.test.' . rand(1, 999) . '@erp-hris.com',
            'phone_number'   => '081234567890',
            'place_of_birth' => 'Jakarta',
            'date_of_birth'  => '1995-05-12',
            'address'        => 'Jl. Sudirman No. 10',
            'id_number'      => '3171011205950001',
            'age'            => 31,
            'role_id'        => 1, 
            'status'         => 'active'
        ]);

        // 2. Tambah data Inactive
        $employeeInactive = Employee::create([
            'name'           => 'Siti Aminah Test',
            'email'          => 'siti.test.' . rand(1, 999) . '@erp-hris.com',
            'phone_number'   => '089876543210',
            'place_of_birth' => 'Bandung',
            'date_of_birth'  => '1998-09-20',
            'address'        => 'Jl. Dago No. 45',
            'id_number'      => '3273012009980002',
            'age'            => 28,
            'role_id'        => 1,
            'status'         => 'inactive'
        ]);

        // Memastikan data benar-benar masuk ke database kamu
        $this->assertDatabaseHas('employees', [
            'email' => $employeeActive->email,
            'status' => 'active',
        ]);

        $this->assertDatabaseHas('employees', [
            'email' => $employeeInactive->email,
            'status' => 'inactive',
        ]);
    }
}
