<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeShift extends Model
{
    use HasFactory;

    protected $table = 'employee_shifts';

    protected $fillable = [
        'employee_id',
        'shift_id',
        'effective_date',
        'end_date',
    ];

    protected $casts = [
        'effective_date' => 'date',
        'end_date'       => 'date',
    ];

    /**
     * Karyawan pemilik assignment ini.
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * Shift yang di-assign.
     */
    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }

    /**
     * Scope: hanya assignment yang masih aktif (end_date null atau di masa depan).
     */
    public function scopeActive($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('end_date')
              ->orWhere('end_date', '>=', now()->toDateString());
        });
    }
}
