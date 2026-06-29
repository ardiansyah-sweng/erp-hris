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

    public function test_filter_payroll_by_employee_id()
    {
        $employee = Employee::create([
            'name' => 'Filter Test Employee',
            'email' => 'filter@gmail.com',
            'phone_number' => '08123456789',
            'place_of_birth' => 'Jakarta',
            'date_of_birth' => '2000-01-01',
            'address' => 'Jl. Filter',
            'id_number' => '111111111',
            'age' => 25,
            'role_id' => 1,
        ]);

        Payroll::create([
            'employee_id' => $employee->id,
            'month' => 5,
            'year' => 2026,
            'basic_salary' => 5000000,
            'allowances' => 1000000,
            'deductions' => 500000,
            'net_salary' => 5500000,
        ]);

        Payroll::create([
            'employee_id' => $employee->id,
            'month' => 6,
            'year' => 2026,
            'basic_salary' => 5000000,
            'allowances' => 1000000,
            'deductions' => 500000,
            'net_salary' => 5500000,
        ]);

        $response = $this->getJson('/payroll/filter?employee_id=' . $employee->id);

        $response->assertStatus(200);
        $response->assertJson([
            'payload' => [
                'statusCode' => 200,
                'message' => 'Payroll filtered successfully!',
            ]
        ]);
    }

    public function test_filter_payroll_by_month_and_year()
    {
        $employee1 = Employee::create([
            'name' => 'Employee 1',
            'email' => 'emp1@gmail.com',
            'phone_number' => '08111111111',
            'place_of_birth' => 'Jakarta',
            'date_of_birth' => '2000-01-01',
            'address' => 'Jl. Test 1',
            'id_number' => '222222222',
            'age' => 25,
            'role_id' => 1,
        ]);

        $employee2 = Employee::create([
            'name' => 'Employee 2',
            'email' => 'emp2@gmail.com',
            'phone_number' => '08222222222',
            'place_of_birth' => 'Bandung',
            'date_of_birth' => '2000-02-02',
            'address' => 'Jl. Test 2',
            'id_number' => '333333333',
            'age' => 26,
            'role_id' => 1,
        ]);

        Payroll::create([
            'employee_id' => $employee1->id,
            'month' => 5,
            'year' => 2026,
            'basic_salary' => 5000000,
            'allowances' => 1000000,
            'deductions' => 500000,
            'net_salary' => 5500000,
        ]);

        Payroll::create([
            'employee_id' => $employee2->id,
            'month' => 5,
            'year' => 2026,
            'basic_salary' => 5000000,
            'allowances' => 1000000,
            'deductions' => 500000,
            'net_salary' => 5500000,
        ]);

        Payroll::create([
            'employee_id' => $employee1->id,
            'month' => 6,
            'year' => 2026,
            'basic_salary' => 5000000,
            'allowances' => 1000000,
            'deductions' => 500000,
            'net_salary' => 5500000,
        ]);

        $response = $this->getJson('/payroll/filter?month=5&year=2026');

        $response->assertStatus(200);
        $response->assertJson([
            'payload' => [
                'statusCode' => 200,
                'message' => 'Payroll filtered successfully!',
            ]
        ]);
    }

    public function test_filter_payroll_returns_empty_when_no_match()
    {
        $response = $this->getJson('/payroll/filter?employee_id=999&month=12&year=2026');

        $response->assertStatus(200);
        $response->assertJson([
            'payload' => [
                'statusCode' => 200,
                'message' => 'Payroll filtered successfully!',
                'data' => []
            ]
        ]);
    }

}