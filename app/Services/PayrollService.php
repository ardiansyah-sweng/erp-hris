<?php

namespace App\Services;

use App\Models\Payroll;
use App\Models\Employee;
use App\Models\Overtime;
use App\Models\Reimbursement;

class PayrollService
{
    protected $overtimeService;
    protected $reimbursementService;

    public function __construct(OvertimeService $overtimeService, ReimbursementService $reimbursementService)
    {
        $this->overtimeService = $overtimeService;
        $this->reimbursementService = $reimbursementService;
    }

    /**
     * Mengambil semua data payroll asli dari database SQL beserta relasi employee.
     */
    public function getAllPayroll()
    {
        // Mengambil data dari database nyata hasil seeder kamu
        return Payroll::with('employee')->get();
    }

    /**
     * Generate payroll otomatis dengan data overtime & reimbursement.
     */
    public function generatePayroll(array $data): Payroll
    {
        $employeeId = $data['employee_id'];
        $month = $data['month'];
        $year = $data['year'];

        // Data gaji pokok & tunjangan dari input
        $basicSalary = $data['basic_salary'];
        $allowances = $data['allowances'] ?? 0;
        $positionAllowance = $data['position_allowance'] ?? 0;
        $mealAllowance = $data['meal_allowance'] ?? 0;
        $transportAllowance = $data['transport_allowance'] ?? 0;
        $deductions = $data['deductions'] ?? 0;

        // Auto-pull data lembur dari OvertimeService
        $overtimeSummary = $this->overtimeService->getEmployeeOvertimeSummary($employeeId, $month, $year);
        $overtimeHours = $overtimeSummary['total_hours'];
        $overtimePay = $overtimeSummary['total_pay'];

        // Auto-pull data reimbursement dari ReimbursementService
        $reimbursementTotal = $this->reimbursementService->getEmployeeReimbursementTotal($employeeId, $month, $year);

        // Hitung potongan pajak dan BPJS
        $grossSalary = $basicSalary + $allowances + $positionAllowance + $mealAllowance + $transportAllowance + $overtimePay;
        $pph21 = $this->calculatePPh21($grossSalary);
        $bpjsKesehatan = $this->calculateBPJSKesehatan($basicSalary);
        $bpjsKetenagakerjaan = $this->calculateBPJSKetenagakerjaan($basicSalary);

        // Total pendapatan dan potongan
        $totalEarnings = $grossSalary + $reimbursementTotal;
        $totalDeductions = $deductions + $pph21 + $bpjsKesehatan + $bpjsKetenagakerjaan;
        $netSalary = $totalEarnings - $totalDeductions;

        return Payroll::create([
            'employee_id'          => $employeeId,
            'month'                => $month,
            'year'                 => $year,
            'basic_salary'         => $basicSalary,
            'allowances'           => $allowances,
            'position_allowance'   => $positionAllowance,
            'meal_allowance'       => $mealAllowance,
            'transport_allowance'  => $transportAllowance,
            'overtime_hours'       => $overtimeHours,
            'overtime_pay'         => $overtimePay,
            'reimbursement_total'  => $reimbursementTotal,
            'deductions'           => $deductions,
            'pph21'                => $pph21,
            'bpjs_kesehatan'       => $bpjsKesehatan,
            'bpjs_ketenagakerjaan' => $bpjsKetenagakerjaan,
            'net_salary'           => $netSalary,
            'status'               => $data['status'] ?? 'pending',
        ]);
    }

    /**
     * Hitung PPh 21 bulanan (simplified).
     * Tarif: 5% untuk penghasilan s/d 5jt, 15% s/d 5-20jt, dst.
     */
    public function calculatePPh21(float $grossMonthly): float
    {
        // PTKP bulanan (TK/0) = 54.000.000 / 12 = 4.500.000
        $ptkpMonthly = 4500000;
        $taxableIncome = max(0, $grossMonthly - $ptkpMonthly);

        if ($taxableIncome <= 0) {
            return 0;
        }

        // Tarif pajak progresif (dibagi 12 untuk bulanan)
        $annualTaxable = $taxableIncome * 12;

        if ($annualTaxable <= 60000000) {
            $annualTax = $annualTaxable * 0.05;
        } elseif ($annualTaxable <= 250000000) {
            $annualTax = 3000000 + ($annualTaxable - 60000000) * 0.15;
        } elseif ($annualTaxable <= 500000000) {
            $annualTax = 31500000 + ($annualTaxable - 250000000) * 0.25;
        } else {
            $annualTax = 93750000 + ($annualTaxable - 500000000) * 0.30;
        }

        return round($annualTax / 12, 2);
    }

    /**
     * Hitung BPJS Kesehatan karyawan (1% dari gaji pokok).
     */
    public function calculateBPJSKesehatan(float $basicSalary): float
    {
        return round($basicSalary * 0.01, 2);
    }

    /**
     * Hitung BPJS Ketenagakerjaan karyawan (2% dari gaji pokok).
     */
    public function calculateBPJSKetenagakerjaan(float $basicSalary): float
    {
        return round($basicSalary * 0.02, 2);
    }

    public function updatePayroll(int $id, array $data): ?Payroll
    {
        $payroll = Payroll::find($id);

        if (! $payroll) {
            return null;
        }

        $basicSalary = $data['basic_salary'] ?? $payroll->basic_salary;
        $allowances = $data['allowances'] ?? $payroll->allowances;
        $positionAllowance = $data['position_allowance'] ?? $payroll->position_allowance;
        $mealAllowance = $data['meal_allowance'] ?? $payroll->meal_allowance;
        $transportAllowance = $data['transport_allowance'] ?? $payroll->transport_allowance;
        $overtimePay = $data['overtime_pay'] ?? $payroll->overtime_pay;
        $reimbursementTotal = $data['reimbursement_total'] ?? $payroll->reimbursement_total;
        $deductions = $data['deductions'] ?? $payroll->deductions;
        $pph21 = $data['pph21'] ?? $payroll->pph21;
        $bpjsKesehatan = $data['bpjs_kesehatan'] ?? $payroll->bpjs_kesehatan;
        $bpjsKetenagakerjaan = $data['bpjs_ketenagakerjaan'] ?? $payroll->bpjs_ketenagakerjaan;

        $totalEarnings = $basicSalary + $allowances + $positionAllowance + $mealAllowance + $transportAllowance + $overtimePay + $reimbursementTotal;
        $totalDeductions = $deductions + $pph21 + $bpjsKesehatan + $bpjsKetenagakerjaan;

        $data['net_salary'] = $totalEarnings - $totalDeductions;

        $payroll->update($data);

        return $payroll->load('employee');
    }

    public function destroyPayroll(int $id): ?Payroll
    {
        $payroll = Payroll::with('employee')->find($id);

        if (! $payroll) {
            return null;
        }

        $payroll->delete();

        return $payroll;
    }
}