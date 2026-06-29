<?php

namespace Tests\Unit;

use Tests\TestCase; // ◄ Ganti ke Tests\TestCase bawaan Laravel agar bisa pakai database
use App\Services\PayrollService;
use App\Models\Payroll;
use App\Models\Employee;
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

    public function test_filter_payroll_by_employee_id(): void
    {
        // 1. Arrange: Buat 2 employee dengan payroll masing-masing
        $employee1 = Employee::factory()->create();
        $employee2 = Employee::factory()->create();

        Payroll::factory(2)->create(['employee_id' => $employee1->id]);
        Payroll::factory(1)->create(['employee_id' => $employee2->id]);

        // 2. Act: Filter payroll berdasarkan employee
        $service = new PayrollService();
        $result = $service->filterPayroll(employee_id: $employee1->id);

        // 3. Assert: Pastikan hanya payroll employee 1 yang kembali (2 data)
        $this->assertCount(2, $result);
        $result->each(function ($payroll) use ($employee1) {
            $this->assertEquals($employee1->id, $payroll->employee_id);
        });
    }

    public function test_filter_payroll_by_month_and_year(): void
    {
        // 1. Arrange: Buat payroll dengan bulan dan tahun berbeda
        Payroll::factory(2)->create(['month' => 5, 'year' => 2026]);
        Payroll::factory(1)->create(['month' => 6, 'year' => 2026]);
        Payroll::factory(1)->create(['month' => 5, 'year' => 2027]);

        // 2. Act: Filter payroll untuk bulan 5 tahun 2026
        $service = new PayrollService();
        $result = $service->filterPayroll(month: 5, year: 2026);

        // 3. Assert: Pastikan hanya 2 payroll dengan bulan 5 dan tahun 2026 yang kembali
        $this->assertCount(2, $result);
        $result->each(function ($payroll) {
            $this->assertEquals(5, $payroll->month);
            $this->assertEquals(2026, $payroll->year);
        });
    }

    public function test_filter_payroll_with_all_filters(): void
    {
        // 1. Arrange: Buat 2 employees dan payroll dengan kombinasi berbeda
        $employee1 = Employee::factory()->create();
        $employee2 = Employee::factory()->create();

        Payroll::factory()->create([
            'employee_id' => $employee1->id,
            'month' => 5,
            'year' => 2026,
        ]);
        Payroll::factory()->create([
            'employee_id' => $employee1->id,
            'month' => 6,
            'year' => 2026,
        ]);
        Payroll::factory()->create([
            'employee_id' => $employee2->id,
            'month' => 5,
            'year' => 2026,
        ]);

        // 2. Act: Filter dengan semua parameter
        $service = new PayrollService();
        $result = $service->filterPayroll(employee_id: $employee1->id, month: 5, year: 2026);

        // 3. Assert: Pastikan hanya 1 payroll sesuai semua kriteria
        $this->assertCount(1, $result);
        $payroll = $result->first();
        $this->assertEquals($employee1->id, $payroll->employee_id);
        $this->assertEquals(5, $payroll->month);
        $this->assertEquals(2026, $payroll->year);
    }

    public function test_filter_payroll_returns_empty_when_no_match(): void
    {
        // 1. Arrange: Buat beberapa payroll
        Payroll::factory(2)->create();

        // 2. Act: Filter dengan kriteria yang tidak ada di database
        $service = new PayrollService();
        $result = $service->filterPayroll(employee_id: 999);

        // 3. Assert: Pastikan hasilnya kosong
        $this->assertCount(0, $result);
        $this->assertInstanceOf(Collection::class, $result);
    }
}