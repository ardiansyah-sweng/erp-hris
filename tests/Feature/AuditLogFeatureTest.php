<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class AuditLogFeatureTest extends TestCase
{
    // JANGAN di-uncomment/jangan diaktifkan baris di bawah ini 
    // supaya data di database asli kamu gak kehapus otomatis saat ditest.
    // use RefreshDatabase;

    /** @test */
    public function test_skenario_crud_audit_log_berjalan_lancar()
    {
        // ==========================================
        // 1. SKENARIO CREATE (Tambah Log Baru)
        // ==========================================
        $logData = [
            'user_email' => 'testing.crud@company.com',
            'action' => 'CREATE',
            'module' => 'JobRole',
            'description' => 'Mencoba membuat data baru lewat automated testing.',
            'created_at' => now()
        ];

        // Jalankan perintah insert ke database
        $inserted = DB::table('activity_logs')->insert($logData);
        
        // Validasi: Pastikan data berhasil masuk ke database (bernilai true)
        $this->assertTrue($inserted);


        // ==========================================
        // 2. SKENARIO READ (Membaca Data via URL UI)
        // ==========================================
        // Simulasikan robot mengakses URL halaman Audit Log
        $response = $this->get(route('system.audit.temp'));

        // Validasi: Pastikan halaman merespons HTTP 200 OK (berhasil diakses)
        $response->assertStatus(200);


        // ==========================================
        // 3. SKENARIO UPDATE (Mengubah Log)
        // ==========================================
        // Ambil data log terakhir yang baru saja dimasukkan oleh test ini
        $latestLog = DB::table('activity_logs')
            ->where('user_email', 'testing.crud@company.com')
            ->latest('id')
            ->first();

        // Jalankan perintah update berdasarkan ID log tersebut
        DB::table('activity_logs')
            ->where('id', $latestLog->id)
            ->update([
                'description' => 'Deskripsi ini berhasil diubah melalui skenario UPDATE testing.'
            ]);

        // Validasi: Pastikan di database datanya benar-benar sudah berubah
        $this->assertDatabaseHas('activity_logs', [
            'id' => $latestLog->id,
            'description' => 'Deskripsi ini berhasil diubah melalui skenario UPDATE testing.'
        ]);


        // ==========================================
        // 4. SKENARIO DELETE (Menghapus Log)
        // ==========================================
        // Jalankan perintah delete untuk menghapus log testing ini dari database (Biar bersih)
        DB::table('activity_logs')->where('id', $latestLog->id)->delete();

        // Validasi: Pastikan data dengan ID tersebut sudah lenyap dari database
        $this->assertDatabaseMissing('activity_logs', [
            'id' => $latestLog->id
        ]);
    }

    /** @test */
    public function test_generate_data_dummy_untuk_dipamerkan_di_browser()
    {
        // Skenario khusus memasukkan data yang MENETAP di database (GAK DI-DELETE)
        // Ini yang bikin halaman browser kamu nanti ada isinya saat didemokan
        DB::table('activity_logs')->insert([
            [
                'user_email' => 'admin.hris@erphris.com',
                'action' => 'CREATE',
                'module' => 'Payroll',
                'description' => 'Membuat slip gaji baru untuk bulan Juli 2026.',
                'created_at' => now()->subMinutes(10)
            ],
            [
                'user_email' => 'admin.hris@erphris.com',
                'action' => 'UPDATE',
                'module' => 'JobRole',
                'description' => 'Mengubah level jabatan Software Engineer menjadi Senior Staff.',
                'created_at' => now()->subMinutes(2)
            ],
            [
                'user_email' => 'manager.it@erphris.com',
                'action' => 'DELETE',
                'module' => 'Karyawan',
                'description' => 'Menghapus data akun testing magang dari sistem.',
                'created_at' => now()
            ]
        ]);

        // Validasi simpel: Pastikan data dummy di atas minimal berhasil masuk ke DB
        $this->assertDatabaseHas('activity_logs', [
            'user_email' => 'admin.hris@erphris.com',
            'module' => 'Payroll'
        ]);
    }
}