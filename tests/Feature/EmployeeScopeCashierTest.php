<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Employee;
use App\Models\Jobrole;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EmployeeScopeCashierTest extends TestCase
{
    use RefreshDatabase;

    public function test_scope_cashier_returns_only_cashier_employee()
    {
        $cashier = Jobrole::create([
            'role' => 'Cashier'
        ]);

        $manager = Jobrole::create([
            'role' => 'Manager'
        ]);

        Employee::create([
            'name' => 'Budi',
            'email' => 'budi@test.com',
            'phone_number' => '08123',
            'place_of_birth' => 'Jogja',
            'date_of_birth' => '1990-01-01',
            'address' => 'Jl A',
            'id_number' => '1111',
            'role_id' => $cashier->id
        ]);

        Employee::create([
            'name' => 'Siti',
            'email' => 'siti@test.com',
            'phone_number' => '08222',
            'place_of_birth' => 'Solo',
            'date_of_birth' => '1992-01-01',
            'address' => 'Jl B',
            'id_number' => '2222',
            'role_id' => $manager->id
        ]);

        $employees = Employee::cashier()->get();

        $this->assertCount(1, $employees);
        $this->assertEquals('Budi', $employees[0]->name);
    }
}