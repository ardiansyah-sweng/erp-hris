<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveRequest extends Model
{
    use HasFactory;

    protected $table = 'leave_requests';

    protected $fillable = [
        'employee_id',
        'employee_name',
        'start_date',
        'end_date',
        'reason',
        'status',
        'submission_date',
    ];

    protected $appends = [
        'total_days',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'submission_date' => 'date',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'employee_code');
    }

    public function getTotalDaysAttribute()
    {
        if (!$this->start_date || !$this->end_date) {
            return 0;
        }
        return $this->start_date->diffInDays($this->end_date) + 1;
    }
}