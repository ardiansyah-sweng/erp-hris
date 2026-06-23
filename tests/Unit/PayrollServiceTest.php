<?php

namespace Tests\Unit;

use Tests\TestCase; // ◄ Ganti ke Tests\TestCase bawaan Laravel agar bisa pakai database
use App\Services\PayrollService;
use App\Models\Payroll;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;

class PayrollServiceTest extends TestCase
{
    use RefreshDatabase; // ◄ Mengosongkan DB setiap kali test dijalankan

    public function test_get_all_payroll_returns_all_data_from_database(): void
    {
        // 1. Arrange: Buat 3 data payroll tiruan di database menggunakan Factory
        Payroll::factory()->count(3)->create();

        // 2. Act: Panggil fungsi di dalam Service
        $service = new PayrollService();
        $result = $service->getAllPayroll();

        // 3. Assert: Pastikan tipenya benar dan jumlahnya pas 3 sesuai database
        $this->assertInstanceOf(Collection::class, $result);
        $this->assertCount(3, $result);
    }
}