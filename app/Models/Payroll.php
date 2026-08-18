<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payroll extends Model
{
    use HasFactory;
    protected $table = 'payrolls';
    protected $fillable = [
        'employee_id',
        'month',
        'year',
        'basic_salary',
        'allowances',
        'position_allowance',
        'meal_allowance',
        'transport_allowance',
        'overtime_hours',
        'overtime_pay',
        'reimbursement_total',
        'deductions',
        'pph21',
        'bpjs_kesehatan',
        'bpjs_ketenagakerjaan',
        'net_salary',
        'status',
        'payment_date',
    ];

    protected $casts = [
        'basic_salary'         => 'double',
        'allowances'           => 'double',
        'position_allowance'   => 'double',
        'meal_allowance'       => 'double',
        'transport_allowance'  => 'double',
        'overtime_hours'       => 'decimal:1',
        'overtime_pay'         => 'double',
        'reimbursement_total'  => 'double',
        'deductions'           => 'double',
        'pph21'                => 'double',
        'bpjs_kesehatan'       => 'double',
        'bpjs_ketenagakerjaan' => 'double',
        'net_salary'           => 'double',
        'payment_date'         => 'date',
    ];

    /**
     * Total semua pendapatan.
     */
    public function getTotalEarningsAttribute()
    {
        return $this->basic_salary
             + $this->allowances
             + $this->position_allowance
             + $this->meal_allowance
             + $this->transport_allowance
             + $this->overtime_pay
             + $this->reimbursement_total;
    }

    /**
     * Total semua potongan.
     */
    public function getTotalDeductionsAttribute()
    {
        return $this->deductions
             + $this->pph21
             + $this->bpjs_kesehatan
             + $this->bpjs_ketenagakerjaan;
    }

    /**
     * Gaji bersih = total pendapatan - total potongan.
     */
    public function getNetSalaryAttribute()
    {
        return $this->total_earnings - $this->total_deductions;
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}
