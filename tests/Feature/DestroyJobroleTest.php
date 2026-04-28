<?php

namespace Tests\Feature;

use App\Models\Jobrole;
use App\Services\JobroleService;
use Tests\TestCase;

/**
 * Test untuk destroy Jobrole di database asli (bukan virtual)
 * Jalankan: php artisan test --filter=DestroyJobroleTest
 */
class DestroyJobroleTest extends TestCase
{
    /**
     * Test destroy jobrole menggunakan service langsung
     * Data benar-benar dihapus dari database asli
     */
    public function test_destroy_jobrole_from_database(): void
    {
        // Ambil data ID 4 yang sudah ada di database
        $jobrole = Jobrole::find(4);

        if (!$jobrole) {
            $this->markTestSkipped('Data dengan ID 4 tidak ditemukan di database');
        }

        $idTest = $jobrole->id;
        $roleTest = $jobrole->role;

        // Verifikasi data ada di database
        $this->assertDatabaseHas('job_roles', [
            'id' => $idTest,
            'role' => $roleTest
        ]);

        // Jalankan destroy menggunakan service
        $service = new JobroleService();
        $service->destroyJobrole($idTest);

        // Verifikasi data benar-benar hilang dari database
        $this->assertDatabaseMissing('job_roles', [
            'id' => $idTest,
        ]);

        echo "\n✓ Data ID {$idTest} ({$roleTest}) berhasil dihapus dari database!\n";
    }

    /**
     * Test destroy jobrole melalui route DELETE
     */
    public function test_destroy_jobrole_via_route(): void
    {
        // Ambil data ID 5 yang sudah ada di database
        $jobrole = Jobrole::find(5);

        if (!$jobrole) {
            $this->markTestSkipped('Data dengan ID 5 tidak ditemukan di database');
        }

        $idTest = $jobrole->id;
        $roleTest = $jobrole->role;

        // Kirim DELETE request ke route
        $response = $this->delete("/job-roles/{$idTest}");

        // Verifikasi redirect ke /job-roles
        $response->assertRedirect('/job-roles');

        // Verifikasi data benar-benar hilang dari database
        $this->assertDatabaseMissing('job_roles', [
            'id' => $idTest,
        ]);

        echo "\n✓ Data ID {$idTest} ({$roleTest}) berhasil dihapus via route!\n";
    }
}
