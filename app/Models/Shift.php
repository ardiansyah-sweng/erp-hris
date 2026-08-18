<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    use HasFactory;

    protected $table = 'shifts';

    protected $fillable = [
        'name',
        'start_time',
        'end_time',
        'total_hours',
        'is_active',
    ];

    protected $casts = [
        'total_hours' => 'decimal:1',
        'is_active'   => 'boolean',
    ];

    /**
     * Karyawan yang di-assign ke shift ini.
     */
    public function employeeShifts()
    {
        return $this->hasMany(EmployeeShift::class);
    }

    /**
     * Overtime records yang menggunakan shift ini.
     */
    public function overtimes()
    {
        return $this->hasMany(Overtime::class);
    }

    /**
     * Scope hanya shift yang aktif.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Format label shift untuk dropdown.
     */
    public function getLabelAttribute(): string
    {
        return "{$this->name} ({$this->start_time} - {$this->end_time})";
    }
}
