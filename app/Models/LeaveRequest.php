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

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'submission_date' => 'date',
    ];
}