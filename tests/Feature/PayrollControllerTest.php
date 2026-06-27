<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Employee;
use App\Models\Payroll;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\PayrollService;
use App\Http\Controllers\PayrollController;
use Illuminate\Support\Facades\View;

class PayrollControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_store_payroll_success()
    {
        $employee = Employee::create([
            'name' => 'Ilham',
            'email' => 'ilham@gmail.com',
            'phone_number' => '08123456789',
            'place_of_birth' => 'Jakarta',
            'date_of_birth' => '2000-01-01',
            'address' => 'Jl. Testing',
            'id_number' => '123456789',
            'age' => 25,
            'role_id' => 1,
        ]);

        $response = $this->postJson('/payroll', [
            'employee_id' => $employee->id,
            'month' => 5,
            'year' => 2026,
            'basic_salary' => 5000000,
            'allowances' => 1000000,
            'deductions' => 500000,
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('payrolls', [
            'employee_id' => $employee->id,
            'month' => 5,
            'year' => 2026,
        ]);
    }

    public function test_show_payroll_success()
    {
        $employee = Employee::create([
            'name' => 'Ilham',
            'email' => 'ilhamshow@gmail.com',
            'phone_number' => '08123456789',
            'place_of_birth' => 'Bandung',
            'date_of_birth' => '2000-01-01',
            'address' => 'Jl. Show',
            'id_number' => '987654321',
            'age' => 25,
            'role_id' => 1,
        ]);

        $payroll = Payroll::create([
            'employee_id' => $employee->id,
            'month' => 5,
            'year' => 2026,
            'basic_salary' => 5000000,
            'allowances' => 1000000,
            'deductions' => 500000,
            'net_salary' => 5500000,
            'status' => 'pending',
        ]);

        $response = $this->getJson('/payroll/' . $payroll->id);

        $response->assertStatus(200);

        $response->assertJson([
            'payload' => [
                'statusCode' => 200,
                'message' => 'Payroll retrieved successfully!',
            ]
        ]);
    }

    public function test_user_can_access_payroll_index_page(): void
    {
        // 1. Arrange: Siapkan data payroll di database dan user untuk login (jika web memakai auth)
        Payroll::factory()->count(2)->create();
        $user = User::factory()->create();

        // 2. Act: Simulasikan user membuka halaman utama payroll
        // (Sesuaikan dengan nama route kamu, misal 'payroll.index')
        $response = $this->actingAs($user)->get(route('payroll.index'));

        // 3. Assert: Pastikan halaman berhasil terbuka (Status 200 OK)
        $response->assertStatus(200);

        // Pastikan view yang digunakan sudah benar
        $response->assertViewIs('payroll.index');

        // Pastikan variabel 'payrolls' ikut dikirimkan ke halaman view
        $response->assertViewHas('payrolls');
    }

    public function test_export_payroll_to_csv(): void
    {
        // 1. Arrange: siapkan satu data payroll dengan nama karyawan yang jelas
        $employee = Employee::factory()->create(['name' => 'Budi Eksportir']);
        Payroll::factory()->create(['employee_id' => $employee->id]);

        // 2. Act: minta file export
        $response = $this->get(route('payroll.export'));

        // 3. Assert: respons CSV yang dapat di-download dan berisi data karyawan
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/csv; charset=UTF-8');
        $this->assertStringContainsString('attachment', $response->headers->get('Content-Disposition'));
        $this->assertStringContainsString('Budi Eksportir', $response->streamedContent());
    }

    public function test_edit_payroll_page_loads(): void
    {
        $payroll = Payroll::factory()->create();

        $response = $this->get(route('payroll.edit', $payroll->id));

        $response->assertStatus(200);
        $response->assertViewIs('payroll.edit');
        $response->assertViewHas('payroll');
        $response->assertViewHas('employees');
    }

    public function test_update_payroll_recalculates_net_salary(): void
    {
        $employee = Employee::factory()->create();
        $payroll = Payroll::factory()->create([
            'employee_id'  => $employee->id,
            'basic_salary' => 5000000,
            'allowances'   => 0,
            'deductions'   => 0,
            'net_salary'   => 5000000,
            'status'       => 'pending',
        ]);

        $response = $this->put(route('payroll.update', $payroll->id), [
            'employee_id'  => $employee->id,
            'month'        => 6,
            'year'         => 2026,
            'basic_salary' => 6000000,
            'allowances'   => 1000000,
            'deductions'   => 500000,
            'status'       => 'paid',
        ]);

        $response->assertRedirect(route('payroll.index'));
        $response->assertSessionHas('success');

        // 6.000.000 + 1.000.000 - 500.000 = 6.500.000
        $this->assertDatabaseHas('payrolls', [
            'id'         => $payroll->id,
            'net_salary' => 6500000,
            'status'     => 'paid',
        ]);
    }

}