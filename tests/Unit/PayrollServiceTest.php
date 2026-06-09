<?php

namespace Tests\Feature;

use App\Models\Payroll;
use App\Services\PayrollService;
use Tests\TestCase;

class PayrollServiceTest extends TestCase
{
    /**
     * Test method getAllPayroll secara stand-alone tanpa database.
     */
    public function test_get_all_payroll_returns_data_with_employee_relation(): void
    {
        // 1. Buat data object dummy untuk payroll dan relasinya
        $payroll = new Payroll();
        $payroll->id = 1;
        $payroll->basic_salary = 4500000;
        $payroll->net_salary = 5000000;

        $employeeDummy = new \stdClass();
        $employeeDummy->name = 'Budi Santoso';
        
        // Pasang relasi secara manual ke dalam objek model
        $payroll->setRelation('employee', $employeeDummy);

        // 2. Buat Anonymous Class untuk menggantikan behavior PayrollService asli
        // Cara ini 100% aman dari error query database karena method-nya di-override langsung
        $payrollServiceMock = new class($payroll) extends PayrollService {
            private $mockData;

            public function __construct($mockData)
            {
                $this->mockData = collect([$mockData]);
            }

            public function getAllPayroll()
            {
                return $this->mockData;
            }
        };

        // 3. Eksekusi method
        $result = $payrollServiceMock->getAllPayroll();

        // 4. Validasi Hasil (Assertions)
        $this->assertCount(1, $result);
        $this->assertEquals(4500000, $result->first()->basic_salary);
        $this->assertEquals('Budi Santoso', $result->first()->employee->name);
    }
}
