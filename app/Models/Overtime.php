<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Overtime extends Model
{
    use HasFactory;

    protected $table = 'overtimes';

    protected $fillable = [
        'employee_id',
        'date',
        'shift_id',
        'scheduled_out',
        'actual_out',
        'overtime_hours',
        'hourly_rate',
        'overtime_pay',
        'status',
        'approved_by',
        'notes',
    ];

    protected $casts = [
        'date'           => 'date',
        'overtime_hours' => 'decimal:1',
        'hourly_rate'    => 'double',
        'overtime_pay'   => 'double',
    ];

    /**
     * Karyawan yang lembur.
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * Shift referensi saat lembur.
     */
    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }

    /**
     * User yang meng-approve lembur.
     */
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Scope: hanya yang approved.
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope: hanya yang pending.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Hitung upah lembur berdasarkan aturan:
     * Jam ke-1: 1.5x upah per jam
     * Jam ke-2+: 2.0x upah per jam
     */
    public static function calculatePay(float $hourlyRate, float $overtimeHours): float
    {
        if ($overtimeHours <= 0) {
            return 0;
        }

        $firstHourPay = min($overtimeHours, 1) * 1.5 * $hourlyRate;
        $remainingHours = max(0, $overtimeHours - 1);
        $remainingPay = $remainingHours * 2.0 * $hourlyRate;

        return round($firstHourPay + $remainingPay, 2);
    }
}
