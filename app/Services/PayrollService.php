<?php

namespace App\Services;

use App\Models\Payroll;

class PayrollService
{
    /**
     * Mengambil semua data payroll berupa data statis (4 Data Dummy).
     */
    public function getAllPayroll()
    {
        // Data 1: Barista (Paid)
        $payroll1 = new Payroll();
        $payroll1->id = 1;
        $payroll1->month = 6;
        $payroll1->year = 2026;
        $payroll1->basic_salary = 4500000;
        $payroll1->allowances = 1000000;
        $payroll1->deductions = 200000;
        $payroll1->net_salary = ($payroll1->basic_salary + $payroll1->allowances) - $payroll1->deductions;
        $payroll1->status = 'paid';
        
        $employee1 = new \stdClass();
        $employee1->name = 'Budi Santoso';
        $employee1->job_role = 'Barista';
        $payroll1->setRelation('employee', $employee1);

        // Data 2: Kasir (Paid)
        $payroll2 = new Payroll();
        $payroll2->id = 2;
        $payroll2->month = 6;
        $payroll2->year = 2026;
        $payroll2->basic_salary = 4200000;
        $payroll2->allowances = 800000;
        $payroll2->deductions = 150000;
        $payroll2->net_salary = ($payroll2->basic_salary + $payroll2->allowances) - $payroll2->deductions;
        $payroll2->status = 'paid';

        $employee2 = new \stdClass();
        $employee2->name = 'Siti Aminah';
        $employee2->job_role = 'Kasir';
        $payroll2->setRelation('employee', $employee2);

        // Data 3: Kitchen / Cook (Pending)
        $payroll3 = new Payroll();
        $payroll3->id = 3;
        $payroll3->month = 6;
        $payroll3->year = 2026;
        $payroll3->basic_salary = 4800000;
        $payroll3->allowances = 1200000;
        $payroll3->deductions = 500000; // Misal ada potongan kas bon
        $payroll3->net_salary = ($payroll3->basic_salary + $payroll3->allowances) - $payroll3->deductions;
        $payroll3->status = 'pending';

        $employee3 = new \stdClass();
        $employee3->name = 'Andi Wijaya';
        $employee3->job_role = 'Kitchen Helper';
        $payroll3->setRelation('employee', $employee3);

        // Data 4: Supervisor (Pending)
        $payroll4 = new Payroll();
        $payroll4->id = 4;
        $payroll4->month = 6;
        $payroll4->year = 2026;
        $payroll4->basic_salary = 6000000;
        $payroll4->allowances = 1500000;
        $payroll4->deductions = 250000;
        $payroll4->net_salary = ($payroll4->basic_salary + $payroll4->allowances) - $payroll4->deductions;
        $payroll4->status = 'pending';

        $employee4 = new \stdClass();
        $employee4->name = 'Eko Prasetyo';
        $employee4->job_role = 'Store Supervisor';
        $payroll4->setRelation('employee', $employee4);

        // Bungkus semua objek ke dalam collection dan kembalikan
        return collect([$payroll1, $payroll2, $payroll3, $payroll4]);
    }
}