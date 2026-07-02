<?php

namespace Tests\Feature;

use App\Models\LeaveRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LeaveRequestControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Halaman absensi/cuti me-render Blade yang memakai @vite,
        // matikan Vite agar tidak butuh hasil build saat testing.
        $this->withoutVite();
    }

    public function test_index_menampilkan_daftar_pengajuan_cuti()
    {
        LeaveRequest::factory()->create(['employee_name' => 'Budi Santoso']);

        $response = $this->get(route('leave_request.index'));

        $response->assertStatus(200);
        $response->assertViewIs('leave_request.index');
        $response->assertViewHas('leaveRequests');
        $response->assertSee('Budi Santoso');
    }

    public function test_index_dapat_mencari_pengajuan_berdasarkan_nama()
    {
        LeaveRequest::factory()->create(['employee_name' => 'Budi Santoso']);
        LeaveRequest::factory()->create(['employee_name' => 'Siti Aminah']);

        $response = $this->get(route('leave_request.index', ['search' => 'Budi']));

        $response->assertStatus(200);
        $response->assertSee('Budi Santoso');
        $response->assertDontSee('Siti Aminah');
    }

    public function test_store_menyimpan_pengajuan_cuti_baru()
    {
        $payload = [
            'employee_id' => 'EMP001',
            'employee_name' => 'Siti Aminah',
            'start_date' => '2026-07-01',
            'end_date' => '2026-07-03',
            'reason' => 'Acara keluarga',
        ];

        $response = $this->post(route('leave_request.store'), $payload);

        $response->assertRedirect(route('leave_request.index'));

        // Status otomatis "Pending" dan submission_date terisi oleh controller
        $this->assertDatabaseHas('leave_requests', [
            'employee_id' => 'EMP001',
            'employee_name' => 'Siti Aminah',
            'reason' => 'Acara keluarga',
            'status' => 'Pending',
        ]);
    }

    public function test_show_menampilkan_detail_pengajuan_cuti()
    {
        $leaveRequest = LeaveRequest::factory()->create();

        $response = $this->get(route('leave_request.detail', $leaveRequest->id));

        $response->assertStatus(200);
        $response->assertViewIs('leave_request.detail');
        $response->assertViewHas('leaveRequest');
    }

    public function test_show_mengembalikan_404_jika_data_tidak_ada()
    {
        $response = $this->get(route('leave_request.detail', 9999));

        $response->assertStatus(404);
    }

    public function test_edit_menampilkan_form_edit()
    {
        $leaveRequest = LeaveRequest::factory()->create();

        $response = $this->get(route('leave_request.edit', $leaveRequest->id));

        $response->assertStatus(200);
        $response->assertViewIs('leave_request.edit');
        $response->assertViewHas('leaveRequest');
    }

    public function test_edit_mengembalikan_404_jika_data_tidak_ada()
    {
        $response = $this->get(route('leave_request.edit', 9999));

        $response->assertStatus(404);
    }

    public function test_update_memperbarui_pengajuan_cuti()
    {
        $leaveRequest = LeaveRequest::factory()->create([
            'employee_name' => 'Nama Lama',
            'status' => 'Pending',
        ]);

        $payload = [
            'employee_id' => $leaveRequest->employee_id,
            'employee_name' => 'Nama Baru',
            'start_date' => '2026-08-01',
            'end_date' => '2026-08-05',
            'reason' => 'Alasan diperbarui',
            'status' => 'Approved',
        ];

        $response = $this->put(route('leave_request.update', $leaveRequest->id), $payload);

        $response->assertRedirect(route('leave_request.index'));

        $this->assertDatabaseHas('leave_requests', [
            'id' => $leaveRequest->id,
            'employee_name' => 'Nama Baru',
            'status' => 'Approved',
        ]);
    }

    public function test_update_mengembalikan_404_jika_data_tidak_ada()
    {
        $payload = [
            'employee_id' => 'EMP999',
            'employee_name' => 'Tidak Ada',
            'start_date' => '2026-08-01',
            'end_date' => '2026-08-05',
            'reason' => 'Alasan',
            'status' => 'Approved',
        ];

        $response = $this->put(route('leave_request.update', 9999), $payload);

        $response->assertStatus(404);
    }

    public function test_destroy_menghapus_pengajuan_cuti()
    {
        $leaveRequest = LeaveRequest::factory()->create();

        $response = $this->delete(route('leave_request.destroy', $leaveRequest->id));

        $response->assertRedirect(route('leave_request.index'));
        $this->assertDatabaseMissing('leave_requests', ['id' => $leaveRequest->id]);
    }

    public function test_destroy_mengembalikan_404_jika_data_tidak_ada()
    {
        $response = $this->delete(route('leave_request.destroy', 9999));

        $response->assertStatus(404);
    }
}
