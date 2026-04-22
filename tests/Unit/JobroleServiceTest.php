<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Jobrole;
use App\Services\JobroleService;

class JobroleServiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test case untuk memastikan method updateJobrole berhasil memperbarui data
     * Update: Menggunakan kolom 'role' dan mengecek keberadaan data di tabel 'job_roles'
     */
    public function test_update_jobrole_successfully()
    {
        // Siapkan data awal di tabel 'job_roles'
        $jobrole = Jobrole::create([
            'role' => 'Software Engineer'
        ]);

        // Jalankan fungsi update melalui service
        $service = new JobroleService();
        $service->updateJobrole($jobrole->id, [
            'role' => 'Senior Software Engineer'
        ]);

        // Pastikan perubahan tersimpan di database secara akurat
        $this->assertDatabaseHas('job_roles', [
            'id' => $jobrole->id,
            'role' => 'Senior Software Engineer'
        ]);
    }
}