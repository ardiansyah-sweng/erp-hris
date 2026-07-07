<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class AuditLogFeatureTest extends TestCase
{
    // komen refreshdatabase dulu kalo mau di test
    // use RefreshDatabase;

    /** @test */
    public function test_halaman_audit_log_bisa_diakses_dan_menampilkan_data_dari_test_seeder()
    {
        // 1. OTOMATIS GENERATE DATA DUMMY SAAT TEST DIJALANKAN
        DB::table('activity_logs')->insert([
            [
                'user_email' => 'admin.hris@company.com',
                'action' => 'CREATE',
                'module' => 'Employee',
                'description' => 'Membuat data karyawan baru bernama Ahmad Fauzi.',
                'created_at' => now()->subMinutes(15)
            ],
            [
                'user_email' => 'manager.payroll@company.com',
                'action' => 'UPDATE',
                'module' => 'Payroll',
                'description' => 'Mengubah nominal tunjangan fungsional divisi IT.',
                'created_at' => now()->subMinutes(5)
            ]
        ]);

        // 2. SIMULASIKAN AKSES KE URL HALAMAN AUDIT
        $response = $this->get(route('system.audit.temp'));

        // 3. VALIDASI: Pastikan halaman merespons dengan HTTP 200 OK
        $response->assertStatus(200);

        // 4. VALIDASI: Pastikan data dummy yang dibuat di atas muncul di struktur HTML teks halaman
        $response->assertSee('admin.hris@company.com');
        $response->assertSee('CREATE');
        $response->assertSee('Membuat data karyawan baru bernama Ahmad Fauzi.');
        
        $response->assertSee('manager.payroll@company.com');
        $response->assertSee('UPDATE');
    }
}